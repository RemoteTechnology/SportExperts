<?php

namespace App\Repository\Filter\Entities\Events;

use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

require_once dirname(__DIR__, 2) . '/Domain/Constants/FieldConst.php';

class EventToParticipantFilterRepository
{
    public mixed $table;
    public function __construct()
    {
        $this->table = DB::table(TABLE_PARTICIPANTS);
    }

    private function initQuery(
        Builder $query,
        string $tableSearch,
        string $fieldSearch,
        string $table,
        string $tableFieldIdentifier
    ): Builder
    {
        return $query->join($tableSearch,
            "{$table}.{$fieldSearch}",
            '=',
            "{$tableSearch}.{$tableFieldIdentifier}")
            ->select("{$tableSearch}." . FIELD_ALL);
    }
    private function builder(array $context): Builder|string
    {
        $query = $this->table;
        foreach ($context as $key => $value)
        {
            switch ($key){
                case FIELD_USER_ID:
                    $query = $this->initQuery($query,
                        TABLE_EVENT,
                        FIELD_EVENT_ID,
                        TABLE_PARTICIPANTS,
                        FIELD_ID);
                    $query->where([TABLE_PARTICIPANTS . '.' . FIELD_USER_ID => $value]);
                    break;
                case FIELD_TEAM_KEY:
//                    $query = $this->initQuery($query,
//                        TABLE_TEAM,
//                        FIELD_TEAM_KEY,
//                        TABLE_PARTICIPANTS,
//                        FIELD_TEAM_KEY);
                    break;
                default:
                    break;
            }
        }
        return $query;
    }

    /**
     * @param array $context
     * @param int $limit
     * @return Collection
     */
    public function filterAfterDate(array $context, int $limit=9): Collection|array
    {
        $currentDateTime = Carbon::now();
        $query = new Collection($this->builder($context)->paginate($limit));
        $query->where(TABLE_EVENT . '.' . FIELD_START_DATE, '>', $currentDateTime);
        $query->where(TABLE_EVENT . '.' . FIELD_START_TIME, '>', $currentDateTime);
        return $query;
    }

    public function filterBeforeDate(array $context, int $limit=9): Collection
    {
        $currentDateTime = Carbon::now();
        $query = new Collection($this->builder($context)->paginate($limit));
        $query->where(TABLE_EVENT . '.' . FIELD_START_DATE, '<', $currentDateTime);
        $query->where(TABLE_EVENT . '.' . FIELD_START_TIME, '<', $currentDateTime);
        return $query;
    }

    public function filterDate(array $context, int $limit=9): Collection
    {
        return new Collection($this->builder($context)->paginate($limit));
    }
}
