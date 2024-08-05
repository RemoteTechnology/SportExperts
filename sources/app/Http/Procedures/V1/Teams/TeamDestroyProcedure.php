<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Teams;

use App\Http\Requests\Teams\TeamReadRequest;
use App\Http\Resources\Teams\TeamResource;
use App\Repository\TeamRepository;
use Illuminate\Http\JsonResponse;
use Sajya\Server\Procedure;

class TeamDestroyProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'TeamDestroyProcedure';

    private TeamRepository $operation;

    public function __construct(TeamRepository $operation) {
        $this->operation = $operation;
    }

    /**
     * Execute the procedure.
     *
     * @param TeamReadRequest $request
     *
     * @return JsonResponse
     */
    public function handle(TeamReadRequest $request): JsonResponse
    {
        $team = $request->validated();
        return new JsonResponse(
            data: new TeamResource(
                $this->operation->destroy(
                    $this->operation->findById($team['id'])
                )
            ),
            status: 201
        );
    }
}
