<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Events;

use App\Http\Requests\Events\EventReadRequest;
use App\Http\Resources\Events\EventResource;
use App\Repository\EventRepository;
use Illuminate\Http\JsonResponse;
use Sajya\Server\Procedure;

class EventReadProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'EventReadProcedure';

    private EventRepository $operation;

    public function __construct(EventRepository $operation) {
        $this->operation = $operation;
    }

    /**
     * Execute the procedure.
     *
     * @param EventReadRequest $request
     *
     * @return JsonResponse
     */
    public function handle(EventReadRequest $request): JsonResponse
    {
        $event = $request->validated();
        return new JsonResponse(
            data: new EventResource(
                $this->operation->findById((int)$event['id'])
            ),
            status: 201
        );
    }
}
