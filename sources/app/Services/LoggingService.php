<?php

namespace App\Services;

use App\Domain\Abstracts\AbstractLogger;
use App\Domain\Constants\LogLevelEnum;
use App\Domain\Interfaces\Repositories\Entities\LoggingRepositoryInterface;
use App\Domain\Interfaces\Services\LoggingServiceInterface;
use Illuminate\Support\Str;

class LoggingService extends AbstractLogger implements LoggingServiceInterface
{
    protected LoggingRepositoryInterface $repository;

    /**
     * @param LoggingRepositoryInterface $repository
     */
    public function __construct(LoggingRepositoryInterface $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }
    public function write(LogLevelEnum $level, mixed $values): void
    {
        $this->repository->store([
            'level'         => $level,
            'key'           => Str::uuid()->toString(),
            'root'          => $this->root($level),
            'action'        => $values['action'],
            'description'   => $values['description'],
            'input_data'    => $values['input_data'],
            'slug'          => $values['slug'],
            'created_date'  => date('d-m-Y-H-i-s'),
        ]);
    }
}
