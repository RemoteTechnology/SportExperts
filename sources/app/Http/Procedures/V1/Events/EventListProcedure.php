<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Events;

use App\Http\Resources\EventResource;
use App\Repository\EventRepository;
use Illuminate\Http\JsonResponse;
use Sajya\Server\Procedure;

class EventListProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'EventListProcedure';

    private EventRepository $operation;

    public function __construct(EventRepository $operation) {
        $this->operation = $operation;
    }

    /**
     * Execute the procedure.
     *
     * @return JsonResponse
     */
    public function handle(): JsonResponse
    {
        return new JsonResponse(
            data: EventResource::collection(
                $this->operation->list()
            ),
            status: 201
        );
    }
}
