<?php

namespace App\Repository\Filter\Entities\Participants;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

require_once dirname(__DIR__, 2) . '/Domain/Constants/FieldConst.php';

class ParticipantOwnerFilterRepository
{
    public mixed $table;
    public function __construct()
    {
        $this->table = DB::table(TABLE_PARTICIPANTS);
    }
    // TODO: Соеденить в 1 метод и назвать это иначе "поиск"
    private function initQuery(Builder $query, array $attributes): Builder
    {
        foreach ($attributes as $key => $value)
        {
            $query->select(DB::raw('DISTINCT ' . TABLE_PARTICIPANTS . '.' . FIELD_INVITED_USER_ID), FIELD_ALL)
                ->join(TABLE_USERS,
                TABLE_PARTICIPANTS . '.' . $key,
                '=',
                TABLE_USERS . '.' .FIELD_ID);
//            $query->where([FIELD_USER_ID => $value]);
        }
        return $query;
    }

    private function builder(array $context): Builder
    {
        return $this->initQuery($this->table, $context);
    }

    public function filter(array $context, int $limit=9): Collection
    {
        return new Collection(
            $this->builder($context)
            ->paginate($limit)
        );
    }
}
