<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\EventProcedure;

use App\Domain\Interfaces\Repositories\Entities\EventRepositoryInterface;
use App\Http\Requests\Events\StoreEventRequest;
use App\Http\Resources\EventResource;
use Illuminate\Http\JsonResponse;
use Sajya\Server\Procedure;

class EventStoreProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'EventStoreProcedure';

    private EventRepositoryInterface $operation;

    public function __construct(EventRepositoryInterface $operation) {
        $this->operation = $operation;
    }

    /**
     * Execute the procedure.
     *
     * @param StoreEventRequest $request
     *
     * @return JsonResponse
     */
    public function handle(StoreEventRequest $request): JsonResponse
    {
        return new JsonResponse(
            data: new EventResource(
                $this->operation->store(
                    $request->validated()
                )
            ),
            status: 201
        );
    }
}
