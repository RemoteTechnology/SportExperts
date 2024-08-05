<?php

namespace App\Repository;

use App\Domain\Interfaces\Repositories\Entities\LoggingRepositoryInterface;
use App\Models\Logs;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

final class LoggingRepository  //implements LoggingRepositoryInterface
{
    public function store(array $attributes)//: Model|Exception|bool
    {
        return DB::connection('mongodb')
            ->table('logs')
            ->insert($attributes);
    }
}
