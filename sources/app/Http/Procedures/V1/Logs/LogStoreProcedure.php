<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Logs;

use App\Domain\Abstracts\AbstractProcedure;
use App\Domain\Constants\EnumConstants\LogLevelEnum;
use App\Http\Requests\Logs\StoreLogRequest;
use App\Services\LoggingService;
use Sajya\Server\Procedure;

require_once dirname(__DIR__, 4) . '/Domain/Constants/ProcedureNameConst.php';

class LogStoreProcedure extends AbstractProcedure
{
    public static string $name = PROCEDURE_LOG_STORE;
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
        define('ATTRIBUTES', $request->validated());
        $this->loggingService->write(LogLevelEnum::Error, ATTRIBUTES);
    }
}
