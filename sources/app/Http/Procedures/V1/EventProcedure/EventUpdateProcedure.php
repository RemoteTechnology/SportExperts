<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\EventProcedure;

use App\Domain\Interfaces\Repositories\Entities\EventRepositoryInterface;
use App\Domain\Interfaces\Repositories\LCRUD_OperationInterface;
use App\Http\Requests\Events\UpdateEventRequest;
use App\Http\Resources\EventResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Sajya\Server\Procedure;

class EventUpdateProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'EventUpdateProcedure';

    private EventRepositoryInterface $operation;

    public function __construct(EventRepositoryInterface $operation) {
        $this->operation = $operation;
    }

    /**
     * Execute the procedure.
     *
     * @param UpdateEventRequest $request
     *
     * @return JsonResponse
     */
    public function handle(UpdateEventRequest $request): JsonResponse
    {
        $event = $request->validated();
        return new JsonResponse(
            data: new EventResource(
                $this->operation->update(
                    $this->operation->findById($event['id']),
                    $event
                )
            ),
            status: 201
        );
    }
}
