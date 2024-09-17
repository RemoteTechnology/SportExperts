<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Events;

use App\Domain\Abstracts\AbstractProcedure;
use App\Http\Resources\Events\EventCollection;
use App\Repository\EventRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

require_once dirname(__DIR__, 4) . '/Domain/Constants/ProcedureNameConst.php';
require_once dirname(__DIR__, 4) . '/Domain/Constants/FieldConst.php';

class EventListProcedure extends AbstractProcedure
{
    public static string $name = PROCEDURE_EVENT_LIST;
    private EventRepository $eventRepository;

    public function __construct(EventRepository $eventRepository) {
        $this->eventRepository = $eventRepository;
    }

    /**
     * @return JsonResponse
     */
    public function handle(Request $request): JsonResponse
    {
        $repository = $this->eventRepository->list(FIELD_PAGINATE, true, true);
        $collectData = new EventCollection($repository);

        return new JsonResponse(
            data: [
                FIELD_ID => self::identifier(),
                FIELD_ATTRIBUTES => $collectData->resource,
                ...self::meta($request, [])
            ],
            status: Response::HTTP_CREATED
        );
    }
}
