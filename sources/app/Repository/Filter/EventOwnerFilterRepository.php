<?php

namespace App\Repository\Filter;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

require_once dirname(__DIR__, 2) . '/Domain/Constants/EventStatusesConst.php';

require_once dirname(__DIR__, 2) . '/Domain/Constants/FieldConst.php';

class EventOwnerFilterRepository
{
    public mixed $table;
    public function __construct()
    {
        $this->table = DB::table(TABLE_EVENT);
    }
    // TODO: Соеденить в 1 метод и назвать это иначе "поиск"
    private function initQuery(Builder $query, array $attributes): Builder
    {
        foreach ($attributes as $key => $value)
        {
            $query->where([$key => $value]);
        }
        return $query;
    }

    private function builder(array $context, bool $datetimeNow): Builder
    {
        $event =  $this->initQuery($this->table, $context);
        if ($datetimeNow)
        {
            date_default_timezone_set('Europe/Moscow');
            return $event->where(['start_date' => date('Y-m-d')]);
        }
        return $event;
    }

    public function filter(array $context, int $limit=9, bool $datetimeNow=false,string|null $status=null)
    {
        $events = $this->builder($context, $datetimeNow);
        // Жестко обращаем внимание на статус
        if ($status)
        {
            $events->where(['status' => $status]);
        }
        $events->orderBy('start_date', 'desc');
        $events->orderBy('start_time', 'desc');
        return $events->paginate($limit);
    }
}
