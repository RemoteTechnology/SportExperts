<?php

namespace App\Domain\Interfaces\Services;

use App\Domain\Constants\EnumConstants\LogLevelEnum;

interface LoggingServiceInterface
{
    public function write(LogLevelEnum $level, mixed $values): void;
}
