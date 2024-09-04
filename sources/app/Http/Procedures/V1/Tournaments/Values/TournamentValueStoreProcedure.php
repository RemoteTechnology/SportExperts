<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Tournaments\Values;

use App\Http\Requests\TournamentValues\TournamentValueStoreRequest;
use App\Http\Resources\TournamentValues\TournamentValueResource;
use App\Repository\EventRepository;
use App\Repository\ParticipantRepository;
use App\Repository\TournamentRepository;
use App\Repository\TournamentValueRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Sajya\Server\Procedure;

class TournamentValueStoreProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'TournamentValueStoreProcedure';
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
     * Execute the procedure.
     *
     * @param TournamentValueStoreRequest $request
     *
     * @return JsonResponse
     */
    public function handle(TournamentValueStoreRequest $request): JsonResponse
    {
        $attributes = $request->validated();
        $event = $this->eventRepository->findByKey($attributes['event_key']);
        $participant = $this->participantRepository->findByKeyIsEvent([
            'event_id' => $event->id,
            'user_id' => $attributes['user_id']
        ]);
        $tournament = $this->tournamentRepository->findByTournamentKey($attributes['event_key']);
        $attributes['tournament_id'] = $tournament->id;
        $attributes['participants_A'] = $participant->key;
        $attributes['participants_B'] = null;
        return new JsonResponse(
            data: new TournamentValueResource($this->tournamentValueRepository->store($attributes)),
            status: Response::HTTP_CREATED
        );
    }
}
