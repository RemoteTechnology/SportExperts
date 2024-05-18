<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\EventProcedure\Team;

use App\Domain\Interfaces\Repositories\Entities\TeamRepositoryInterface;
use App\Http\Resources\TeamResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Sajya\Server\Procedure;

class EventTeamListProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'EventTeamListProcedure';

    private TeamRepositoryInterface $operation;

    public function __construct(TeamRepositoryInterface $operation) {
        $this->operation = $operation;
    }

    /**
     * Execute the procedure.
     *
     * @return JsonResponse
     */
    public function handle(): JsonResponse
    {
        return new JsonResponse(
            data: TeamResource::collection(
                $this->operation->list()
            ),
            status: 200
        );
    }
}
