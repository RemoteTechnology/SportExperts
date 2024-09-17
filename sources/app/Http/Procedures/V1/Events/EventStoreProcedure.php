<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Events;

use App\Domain\Abstracts\AbstractProcedure;
use App\Http\Requests\Events\StoreEventRequest;
use App\Http\Resources\Events\EventResource;
use App\Repository\EventRepository;
use App\Repository\TournamentAdminRepository;
use App\Repository\TournamentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

require_once dirname(__DIR__, 4) . '/Domain/Constants/EventStatusesConst.php';
require_once dirname(__DIR__, 4) . '/Domain/Constants/ProcedureNameConst.php';
require_once dirname(__DIR__, 4) . '/Domain/Constants/FieldConst.php';

class EventStoreProcedure extends AbstractProcedure
{
    public static string $name = PROCEDURE_EVENT_STORE;
    private EventRepository $eventRepository;
    private TournamentRepository $tournamentRepository;
    private TournamentAdminRepository $tournamentAdminRepository;

    public function __construct(
        EventRepository $eventRepository,
        TournamentRepository $tournamentRepository,
        TournamentAdminRepository $tournamentAdminRepository
    )
    {
        $this->eventRepository = $eventRepository;
        $this->tournamentRepository = $tournamentRepository;
        $this->tournamentAdminRepository = $tournamentAdminRepository;
    }

    /**
     * @param StoreEventRequest $request
     * @return JsonResponse
     */
    public function handle(StoreEventRequest $request): JsonResponse
    {
        $attributes = $request->validated();
        $attributes[FIELD_STATUS] = EVENT_ACTIVE;
        $attributes[FIELD_KEY] = Str::uuid()->toString();
        $repository = $this->eventRepository->store($attributes);

        if ($repository) {
            define("DEFAULT_STAGE", 1);
            $tournamentRepository = $this->tournamentRepository->store([
                FIELD_KEY       => Str::uuid()->toString(),
                FIELD_EVENT_KEY => $repository->key,
                FIELD_STAGE     => DEFAULT_STAGE
            ]);

            if ($tournamentRepository) {
                $tournamentAdmin[FIELD_TOURNAMENT_ID] = $tournamentRepository->id;
                $tournamentAdmin[FIELD_USER_ID] = $repository->user_id;
                $this->tournamentAdminRepository->store($tournamentAdmin);
            }
        }

        return new JsonResponse(
            data: [
                FIELD_ID => self::identifier(),
                FIELD_ATTRIBUTES => new EventResource($repository),
                ...self::meta($request, $attributes)
            ],
            status: Response::HTTP_CREATED
        );
    }
}
