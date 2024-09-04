<?php

namespace App\Domain\Abstracts;

use App\Domain\Constants\EnumConstants\LogLevelEnum;
use Illuminate\Support\Str;

abstract class AbstractLogger
{
    public string $uuid;
    public function __construct()
    {
        $this->uuid = Str::uuid()->toString();
    }
    public function root(LogLevelEnum $level): string
    {
        $timestamp = date('d-m-Y-H-i-s');
        switch ($level)
        {
            case LogLevelEnum::Error:
                return "E:{$timestamp}:{$this->uuid}";
            case LogLevelEnum::Warning:
                return "W:{$timestamp}:{$this->uuid}";
        }
        return "D:{$timestamp}:{$this->uuid}";
    }
    abstract public function write(LogLevelEnum $level, mixed $values): void;
}
