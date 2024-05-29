<?php

namespace App\Repository\Filter;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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

    private function builder(array $context): Builder
    {
        return $this->initQuery($this->table, $context);
    }

    public function filter(array $context, int $limit=9): Collection
    {
        return new Collection($this->builder($context)
            ->orderBy('start_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate($limit));
    }
}
