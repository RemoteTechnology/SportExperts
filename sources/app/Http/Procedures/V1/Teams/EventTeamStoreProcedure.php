<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Teams;

use App\Domain\Interfaces\Repositories\Entities\TeamRepositoryInterface;
use App\Http\Requests\Teams\StoreTeamRequest;
use App\Http\Resources\TeamResource;
use Illuminate\Http\JsonResponse;
use Sajya\Server\Procedure;

class EventTeamStoreProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'EventTeamStoreProcedure';

    private TeamRepositoryInterface $operation;

    public function __construct(TeamRepositoryInterface $operation) {
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
        return new JsonResponse(
            data: new TeamResource(
                $this->operation->store($request->validated())
            ),
            status: 201
        );
    }
}
