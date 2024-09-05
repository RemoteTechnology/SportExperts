<?php

namespace App\Services;

use App\Domain\Abstracts\AbstractLogger;
use App\Domain\Constants\EnumConstants\LogLevelEnum;
use App\Repository\LoggingRepository;
use Illuminate\Support\Str;

class LoggingService extends AbstractLogger //  implements LoggingServiceInterface
{
    protected LoggingRepository $repository;

    /**
     * @param LoggingRepository $repository
     */
    public function __construct(LoggingRepository $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }
    public function write(LogLevelEnum $level, mixed $values):void
    {
        $values['key'] = Str::uuid()->toString();
        $values['level'] = $level;
        $this->repository->store($values);
    }
}
