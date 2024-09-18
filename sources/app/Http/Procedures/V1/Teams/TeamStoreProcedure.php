<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Teams;

use App\Domain\Abstracts\AbstractProcedure;
use App\Http\Requests\Teams\StoreTeamRequest;
use App\Http\Resources\Teams\TeamResource;
use App\Repository\TeamRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

require_once dirname(__DIR__, 4) . '/Domain/Constants/ProcedureNameConst.php';
require_once dirname(__DIR__, 4) . '/Domain/Constants/FieldConst.php';

class TeamStoreProcedure extends AbstractProcedure
{
    public static string $name = PROCEDURE_TEAM_STORE;
    private TeamRepository $teamRepository;

    public function __construct(TeamRepository $teamRepository) {
        $this->teamRepository = $teamRepository;
    }

    /**
     * @param StoreTeamRequest $request
     * @return JsonResponse
     */
    public function handle(StoreTeamRequest $request): JsonResponse
    {
        $attributes = $request->validated();
        $attributes[FIELD_KEY] = Str::uuid()->toString();
        $repository = $this->teamRepository->store($attributes);

        return new JsonResponse(
            data: [
                FIELD_ID => self::identifier(),
                FIELD_ATTRIBUTES => new TeamResource($repository),
                ...self::meta($request, ATTRIBUTES)
            ],
            status: Response::HTTP_CREATED
        );
    }
}
