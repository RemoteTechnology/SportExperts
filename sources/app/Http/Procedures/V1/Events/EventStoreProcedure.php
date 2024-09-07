<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Events;

use App\Http\Requests\Events\StoreEventRequest;
use App\Http\Resources\Events\EventResource;
use App\Repository\EventRepository;
use App\Repository\TournamentAdminRepository;
use App\Repository\TournamentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Sajya\Server\Procedure;

require_once dirname(__DIR__, 4) . '/Domain/Constants/EventStatusesConst.php';

class EventStoreProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'EventStoreProcedure';

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
     * Execute the procedure.
     *
     * @param StoreEventRequest $request
     *
     * @return JsonResponse
     */
    public function handle(StoreEventRequest $request): JsonResponse
    {
        $eventAttributes = $request->validated();
        $eventAttributes['status'] = EVENT_ACTIVE;
        $eventAttributes['key'] = Str::uuid()->toString();
        $event = $this->eventRepository->store($eventAttributes);

        if ($event) {
            define("DEFAULT_STAGE", 1);
            $tournament = $this->tournamentRepository->store([
                'key'       => Str::uuid()->toString(),
                'event_key' => $event->key,
                'stage'     => DEFAULT_STAGE
            ]);

            if ($tournament) {
                $tournamentAdmin['tournament_id'] = $tournament->id;
                $tournamentAdmin['user_id'] = $event->user_id;
                $this->tournamentAdminRepository->store($tournamentAdmin);
            }
        }

        return new JsonResponse(
            data: new EventResource($event),
            status: 201
        );
    }
}
