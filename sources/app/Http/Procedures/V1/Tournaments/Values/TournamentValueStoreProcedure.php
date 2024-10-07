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

require_once dirname(__DIR__, 5) . '/Domain/Constants/FieldConst.php';

class TournamentValueStoreProcedure extends AbstractProcedure
{
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
     * @param TournamentValueStoreRequest $request
     * @return JsonResponse
     */
    public function handle(TournamentValueStoreRequest $request): JsonResponse
    {
        define('ATTRIBUTES', $request->validated());
        $event = $this->eventRepository->findByKey(ATTRIBUTES['event_key']);
        $participant = $this->participantRepository->findByKeyIsEvent([
            'event_id' => $event->id,
            'user_id' => ATTRIBUTES['user_id']
        ]);
        $tournament = $this->tournamentRepository->findByTournamentKey(ATTRIBUTES['event_key']);
        $attributes['tournament_id'] = $tournament[0]->id;
        $attributes['participants_A'] = $participant->key;
        $attributes['participants_B'] = null;

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
