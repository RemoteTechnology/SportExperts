<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Teams;

use App\Http\Requests\Teams\UpdateTeamRequest;
use App\Http\Resources\TeamResource;
use App\Repository\TeamRepository;
use Illuminate\Http\JsonResponse;
use Sajya\Server\Procedure;

class TeamUpdateProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'TeamUpdateProcedure';

    private TeamRepository $operation;

    public function __construct(TeamRepository $operation) {
        $this->operation = $operation;
    }

    /**
     * Execute the procedure.
     *
     * @param UpdateTeamRequest $request
     *
     * @return JsonResponse
     */
    public function handle(UpdateTeamRequest $request): JsonResponse
    {
        $team = $request->validated();
        return new JsonResponse(
            data: new TeamResource(
                $this->operation->update(
                    $this->operation->findById($team['id']),
                    $team
                )
            ),
            status: 201
        );
    }
}
