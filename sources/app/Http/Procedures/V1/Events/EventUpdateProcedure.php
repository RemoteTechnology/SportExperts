<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Events;

use App\Domain\Abstracts\AbstractProcedure;
use App\Http\Requests\Events\UpdateEventRequest;
use App\Http\Resources\Events\EventResource;
use App\Repository\EventRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

require_once dirname(__DIR__, 4) . '/Domain/Constants/ProcedureNameConst.php';
require_once dirname(__DIR__, 4) . '/Domain/Constants/FieldConst.php';

class EventUpdateProcedure extends AbstractProcedure
{
    public static string $name = PROCEDURE_EVENT_UPDATE;
    private EventRepository $eventRepository;

    public function __construct(EventRepository $eventRepository) {
        $this->eventRepository = $eventRepository;
    }

    /**
     * @param UpdateEventRequest $request
     * @return JsonResponse
     */
    public function handle(UpdateEventRequest $request): JsonResponse
    {
        define('ATTRIBUTES', $request->validated());
        $event = $this->eventRepository->findById((int)ATTRIBUTES[FIELD_ID]);
        $repository = $this->eventRepository->update($event, ATTRIBUTES);

        return new JsonResponse(
            data: [
                FIELD_ID => self::identifier(),
                FIELD_ATTRIBUTES => new EventResource($repository),
                ...self::meta($request, ATTRIBUTES)
            ],
            status: Response::HTTP_CREATED
        );
    }
}
