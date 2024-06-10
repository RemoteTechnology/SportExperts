<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Events;

use App\Http\Requests\Events\StoreEventRequest;
use App\Http\Resources\Events\EventResource;
use App\Repository\EventRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Sajya\Server\Procedure;

require_once dirname(__DIR__, 4) . '/Domain/Constants/EventStatusesConst.php';

class EventStoreProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'EventStoreProcedure';

    private EventRepository $operation;

    public function __construct(EventRepository $operation) {
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
        $event = $request->validated();
        $event['status'] = EVENT_ACTIVE;
        $event['key'] = Str::uuid()->toString();
        return new JsonResponse(
            data: new EventResource(
                $this->operation->store(
                    $event
                )
            ),
            status: 201
        );
    }
}
