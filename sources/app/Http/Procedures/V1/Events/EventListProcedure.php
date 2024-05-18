<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Events;

use App\Domain\Interfaces\Repositories\Entities\EventRepositoryInterface;
use App\Http\Resources\EventResource;
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

    private EventRepositoryInterface $operation;

    public function __construct(EventRepositoryInterface $operation) {
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
            status: 200
        );
    }
}
