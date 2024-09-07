<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Events;

use App\Http\Requests\Events\UpdateEventRequest;
use App\Http\Resources\Events\EventResource;
use App\Repository\EventRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Sajya\Server\Procedure;

class EventUpdateProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'EventUpdateProcedure';

    private EventRepository $operation;

    public function __construct(EventRepository $operation) {
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
        $attributes = $request->validated();
        return new JsonResponse(
            data: new EventResource(
                $this->operation->update(
                    $this->operation->findById((int)$attributes['id']),
                    $attributes
                )
            ),
            status: Response::HTTP_CREATED
        );
    }
}
