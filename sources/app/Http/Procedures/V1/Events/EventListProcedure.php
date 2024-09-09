<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Events;

use App\Http\Resources\Events\EventCollection;
use App\Http\Resources\Events\EventResource;
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
        define('DEFAULT_MODE', 'paginate');
        $events = new EventCollection($this->operation->list(DEFAULT_MODE, true, true));
        return new JsonResponse(
            data: $events->resource,
            status: 201
        );
    }
}
