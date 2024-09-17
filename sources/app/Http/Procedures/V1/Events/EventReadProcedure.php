<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Events;

use App\Domain\Abstracts\AbstractProcedure;
use App\Http\Requests\Events\EventReadRequest;
use App\Http\Resources\Events\EventResource;
use App\Repository\EventRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

require_once dirname(__DIR__, 4) . '/Domain/Constants/ProcedureNameConst.php';
require_once dirname(__DIR__, 4) . '/Domain/Constants/FieldConst.php';

class EventReadProcedure extends AbstractProcedure
{
    public static string $name = PROCEDURE_EVENT_READ;
    private EventRepository $eventRepository;

    public function __construct(EventRepository $eventRepository) {
        $this->eventRepository = $eventRepository;
    }

    /**
     * @param EventReadRequest $request
     * @return JsonResponse
     */
    public function handle(EventReadRequest $request): JsonResponse
    {
        define('ATTRIBUTES', $request->validated());
        if (key_exists(FIELD_KEY, ATTRIBUTES))
        {
            $repository = $this->eventRepository->findByKey(ATTRIBUTES[FIELD_KEY]);
        }
        else
        {
            $repository = $this->eventRepository->findById((int)ATTRIBUTES[FIELD_ID]);
        }
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
