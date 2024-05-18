<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Teams;

use App\Domain\Interfaces\Repositories\Entities\TeamRepositoryInterface;
use App\Http\Requests\Teams\UpdateTeamRequest;
use App\Http\Resources\TeamResource;
use Illuminate\Http\JsonResponse;
use Sajya\Server\Procedure;

class EventTeamUpdateProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'EventTeamUpdateProcedure';

    private TeamRepositoryInterface $operation;

    public function __construct(TeamRepositoryInterface $operation) {
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
        $team = $request->validated(); // $this->operation->findById()
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
