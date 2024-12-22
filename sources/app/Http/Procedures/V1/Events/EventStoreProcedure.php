<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Events;

use App\Domain\Abstracts\AbstractProcedure;
use App\Domain\Constants\EnumConstants\EntityLeadsEnum;
use App\Domain\Constants\EnumConstants\StatusLeadEnum;
use App\Http\Requests\Events\StoreEventRequest;
use App\Http\Resources\Events\EventResource;
//use App\Repository\EventRepository;
use App\Repository\LeadRepository;
//use App\Repository\TournamentAdminRepository;
//use App\Repository\TournamentRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

require_once dirname(__DIR__, 4) . '/Domain/Constants/EventStatusesConst.php';
require_once dirname(__DIR__, 4) . '/Domain/Constants/ProcedureNameConst.php';
require_once dirname(__DIR__, 4) . '/Domain/Constants/FieldConst.php';

class EventStoreProcedure extends AbstractProcedure
{
    public static string $name = PROCEDURE_EVENT_STORE;
    private LeadRepository $leadRepository;

    public function __construct(LeadRepository $leadRepository)
    {
        $this->leadRepository = $leadRepository;
    }

    /**
     * @param StoreEventRequest $request
     * @return JsonResponse
     */
    public function handle(StoreEventRequest $request): JsonResponse
    {
        $repository = [];
        $attributes = $request->validated();
        $attributes[FIELD_STATUS] = EVENT_ACTIVE;
        $attributes[FIELD_KEY] = Str::uuid()->toString();
        $key = Str::uuid()->toString();

        if ($this->leadRepository->store(
            $key,
            EntityLeadsEnum::EVENT_LEAD,
            StatusLeadEnum::NOT_PROCESSED,
            $attributes,
            Carbon::now()->timestamp,
        ))
        {
            $repository = $this->leadRepository->findByKey($key);
        }

        return new JsonResponse(
            data: [
                FIELD_ID => self::identifier(),
                FIELD_ATTRIBUTES => $repository[FIELD_DATA], //new EventResource($repository),
                ...self::meta($request, $attributes)
            ],
            status: Response::HTTP_CREATED
        );
        /*
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
        */
    }
}
