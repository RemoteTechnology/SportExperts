<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Teams;

use App\Domain\Interfaces\Repositories\Entities\TeamRepositoryInterface;
use App\Http\Resources\TeamResource;
use Illuminate\Http\JsonResponse;
use Sajya\Server\Procedure;

class EventTeamDestroyProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'EventTeamDestroyProcedure';

    private TeamRepositoryInterface $operation;

    public function __construct(TeamRepositoryInterface $operation) {
        $this->operation = $operation;
    }

    /**
     * Execute the procedure.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function handle(int $id): JsonResponse
    {
        return new JsonResponse(
            data: new TeamResource(
                $this->operation->destroy(
                    $this->operation->findById($id)
                )
            ),
            status: 200
        );
    }
}
