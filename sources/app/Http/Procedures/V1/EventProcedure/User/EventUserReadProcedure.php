<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\EventProcedure\User;

use App\Domain\Interfaces\Repositories\Entities\EventUserRepositoryInterface;
use App\Domain\Interfaces\Repositories\LCRUD_OperationInterface;
use App\Http\Resources\ParticipantResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Sajya\Server\Procedure;

class EventUserReadProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'EventUserReadProcedure';

    private EventUserRepositoryInterface $operation;

    public function __construct(EventUserRepositoryInterface $operation) {
        $this->operation = $operation;
    }

    /**
     * Execute the procedure.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function handle(int $id): JsonResponse
    {
        return new JsonResponse(
            data: new ParticipantResource(
                $this->operation->findById($id)
            ),
            status: 200
        );
    }
}
