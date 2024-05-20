<?php

namespace App\Repository;

use App\Domain\Interfaces\Repositories\Entities\LoggingRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LoggingRepository implements LoggingRepositoryInterface
{
    public function store(array $attributes): Model|Exception|bool
    {
        return DB::connection('logs')
            ->table($attributes['collection'] === 'Warning'? 'warning' : $attributes['mode'])
            ->insert($attributes);
    }
}
