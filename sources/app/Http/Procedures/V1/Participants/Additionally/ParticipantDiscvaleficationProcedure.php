<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Participants\Additionally;

use App\Http\Requests\Participants\Additionally\ParticipantDiscvaleficationRequest;
use App\Http\Resources\TournamentValues\TournamentValueResource;
use App\Repository\EventRepository;
use App\Repository\TournamentValueRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Sajya\Server\Procedure;

class ParticipantDiscvaleficationProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'ParticipantDiscvaleficationProcedure';
    private EventRepository $eventRepository;
    private TournamentValueRepository $tournamentValueRepository;

    public function __construct(
        EventRepository $eventRepository,
        TournamentValueRepository $tournamentValueRepository
    )
    {
        $this->eventRepository = $eventRepository;
        $this->tournamentValueRepository = $tournamentValueRepository;
    }

    /**
     * Execute the procedure.
     *
     * @param ParticipantDiscvaleficationRequest $request
     *
     * @return JsonResponse
     */
    public function handle(ParticipantDiscvaleficationRequest $request): JsonResponse
    {
        $attributes = $request->validated();
        $event = $this->eventRepository->findById($attributes['event_id']);
        return new JsonResponse(
            data: new TournamentValueResource($this->tournamentValueRepository->removeParticipant($event, $attributes)),
            status: Response::HTTP_CREATED
        );
    }
}
