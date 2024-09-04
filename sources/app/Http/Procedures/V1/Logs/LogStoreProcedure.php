<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Logs;

use App\Domain\Constants\EnumConstants\LogLevelEnum;
use App\Http\Requests\Logs\StoreLogRequest;
use App\Services\LoggingService;
use Sajya\Server\Procedure;

class LogStoreProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'LogStoreProcedure';
    public LoggingService $loggingService;
    public function __construct(LoggingService $loggingService)
    {
        $this->loggingService = $loggingService;
    }

    /**
     * @param StoreLogRequest $request
     * @return void
     */
    public function handle(StoreLogRequest $request): void
    {
        $log = $request->validated();
        $this->loggingService->write(LogLevelEnum::Error, $log);
    }
}
