<?php

namespace App\Repository;

use App\Domain\Constants\EnumConstants\EntityLeadsEnum;
use App\Domain\Constants\EnumConstants\StatusLeadEnum;
use Carbon\Carbon;
use Illuminate\Database\Concerns\BuildsQueries;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

require_once dirname(__DIR__, 2) . '/app/Domain/Constants/FieldConst.php';
require_once dirname(__DIR__, 2) . '/app/Domain/Constants/EntitiesConst.php';

final class LeadRepository
{
    /**
     * @return Collection
     */
    public function list(): Collection
    {
        return DB::connection('mongodb')
            ->table(TABLE_LEADS)
            ->get();
    }

    /**
     * @param array $attributes
     * @return bool
     */
    public function store(string $key, EntityLeadsEnum $entity, StatusLeadEnum $status, array $attributes, int $date): bool
    {
        return DB::connection('mongodb')
            ->table(TABLE_LEADS)
            ->insert([
                FIELD_KEY           => $key,
                FIELD_ENTITY        => $entity,
                FIELD_STATUS        => $status,
                FIELD_DATA          => $attributes,
                FIELD_CREATED_AT    => $date,
                FIELD_UPDATED_AT    => $date
            ]);
    }


    /**
     * @param string $key
     * @return Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function findByKey(string $key)
    {
        return DB::connection('mongodb')
            ->table(TABLE_LEADS)
            ->where(FIELD_KEY, '=', $key)->first();
    }

    /**
     * @param string $key
     * @param StatusLeadEnum $status
     * @param int $date
     */
    public function updateStatus(string $key, StatusLeadEnum $status, int $date)
    {
        return  DB::connection('mongodb')
            ->table(TABLE_LEADS)
            ->select()
            ->where(FIELD_KEY, '=', $key)
            ->update([
                FIELD_STATUS => $status,
                FIELD_UPDATED_AT => $date
            ]);
    }
}
