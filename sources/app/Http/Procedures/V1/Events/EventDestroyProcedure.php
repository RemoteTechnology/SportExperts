<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Events;

use App\Domain\Abstracts\AbstractProcedure;
use App\Domain\Interfaces\Repositories\Entities\EventRepositoryInterface;
use App\Http\Requests\Events\EventReadRequest;
use App\Http\Resources\Events\EventResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

require_once dirname(__DIR__, 4) . '/Domain/Constants/ProcedureNameConst.php';
require_once dirname(__DIR__, 4) . '/Domain/Constants/FieldConst.php';

class EventDestroyProcedure extends AbstractProcedure
{
    public static string $name = PROCEDURE_EVENT_DESTROY;
    private EventRepositoryInterface $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository) {
        $this->eventRepository = $eventRepository;
    }

    /**
     * @param EventReadRequest $request
     * @return JsonResponse
     */
    public function handle(EventReadRequest $request): JsonResponse
    {
        define("ATTRIBUTES", $request->validated());
        $event =  $this->eventRepository->findById(ATTRIBUTES[FIELD_ID]);
        $repository = $this->eventRepository->destroy($event);

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
