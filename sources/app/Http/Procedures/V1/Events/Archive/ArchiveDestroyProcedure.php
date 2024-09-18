<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Events\Archive;

use App\Domain\Abstracts\AbstractProcedure;
use App\Http\Requests\Archives\ArchiveRequest;
use App\Http\Resources\Events\EventResource;
use App\Repository\EventRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

require_once dirname(__DIR__, 5) . '/Domain/Constants/EventStatusesConst.php';
require_once dirname(__DIR__, 5) . '/Domain/Constants/ProcedureNameConst.php';

class ArchiveDestroyProcedure extends AbstractProcedure
{
    public static string $name = PROCEDURE_EVENT_ARCHIVE_DESTROY;
    public EventRepository $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    /**
     * @param ArchiveRequest $request
     * @return JsonResponse
     */
    public function handle(ArchiveRequest $request): JsonResponse
    {
        define('ATTRIBUTES', $request->validated());
        $repository = $this->eventRepository->updateStatus(ATTRIBUTES, EVENT_ACTIVE);

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
