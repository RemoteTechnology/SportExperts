<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Teams;

use App\Http\Requests\Teams\StoreTeamRequest;
use App\Http\Resources\TeamResource;
use App\Repository\TeamRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Sajya\Server\Procedure;

class TeamStoreProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'TeamStoreProcedure';

    private TeamRepository $operation;

    public function __construct(TeamRepository $operation) {
        $this->operation = $operation;
    }

    /**
     * Execute the procedure.
     *
     * @param StoreTeamRequest $request
     *
     * @return JsonResponse
     */
    public function handle(StoreTeamRequest $request): JsonResponse
    {
        $team = $request->validated();
        $team['key'] = Str::uuid()->toString();
        return new JsonResponse(
            data: new TeamResource(
                $this->operation->store($team)
            ),
            status: 201
        );
    }
}
