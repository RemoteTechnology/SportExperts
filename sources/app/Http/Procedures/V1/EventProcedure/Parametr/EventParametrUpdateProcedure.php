<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\EventProcedure\Parametr;

use App\Domain\Interfaces\Repositories\LCRUD_OperationInterface;
use Illuminate\Http\Request;
use Sajya\Server\Procedure;

class EventParametrUpdateProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'EventParametrUpdateProcedure';

    private LCRUD_OperationInterface $operation;

    public function __construct(LCRUD_OperationInterface $operation) {
        $this->operation = $operation;
    }

    /**
     * Execute the procedure.
     *
     * @param Request $request
     *
     * @return array|string|integer
     */
    public function handle(Request $request)
    {
        // write your code
    }
}
