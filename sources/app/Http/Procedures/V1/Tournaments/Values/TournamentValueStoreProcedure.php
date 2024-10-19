<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Tournaments\Values;

use App\Domain\Abstracts\AbstractProcedure;
use App\Http\Requests\TournamentValues\TournamentValueStoreRequest;
use App\Http\Resources\TournamentValues\TournamentValueResource;
use App\Repository\EventRepository;
use App\Repository\ParticipantRepository;
use App\Repository\TournamentRepository;
use App\Repository\TournamentValueRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

require_once dirname(__DIR__, 5) . '/Domain/Constants/ProcedureNameConst.php';
require_once dirname(__DIR__, 5) . '/Domain/Constants/FieldConst.php';

class TournamentValueStoreProcedure extends AbstractProcedure
{
    public static string $name = PROCEDURE_TOURNAMENT_VALUE_STORE;
    private EventRepository $eventRepository;
    private ParticipantRepository $participantRepository;
    private TournamentRepository $tournamentRepository;
    private TournamentValueRepository $tournamentValueRepository;
    public function __construct(
        EventRepository $eventRepository,
        ParticipantRepository $participantRepository,
        TournamentRepository $tournamentRepository,
        TournamentValueRepository $tournamentValueRepository
    )
    {
        $this->eventRepository = $eventRepository;
        $this->participantRepository = $participantRepository;
        $this->tournamentRepository = $tournamentRepository;
        $this->tournamentValueRepository = $tournamentValueRepository;
    }

    /**
     * @param TournamentValueStoreRequest $request
     * @return JsonResponse
     */
    public function handle(TournamentValueStoreRequest $request): JsonResponse
    {
        define('ATTRIBUTES', $request->validated());
        $event = $this->eventRepository->findByKey(ATTRIBUTES[FIELD_EVENT_KEY]);
        $participant = $this->participantRepository->findByKeyIsEvent([
            FIELD_EVENT_ID  => $event->id,
            FIELD_USER_ID   => ATTRIBUTES[FIELD_USER_ID]
        ]);
        $tournament = $this->tournamentRepository->findByTournamentKey(ATTRIBUTES[FIELD_EVENT_KEY]);
        $attributes[FIELD_TOURNAMENT_ID] = $tournament[0]->id;
        $attributes[FIELD_PARTICIPANTS_A] = $participant->key;
        $attributes[FIELD_PARTICIPANTS_B] = null;

        $repository = $this->tournamentValueRepository->store($attributes);
        return new JsonResponse(
            data: [
                FIELD_ID => self::identifier(),
                FIELD_ATTRIBUTES => new TournamentValueResource($repository),
                ...self::meta($request, ATTRIBUTES)
            ],
            status: Response::HTTP_CREATED
        );
    }
}
