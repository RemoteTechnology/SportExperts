<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Teams;

use App\Http\Resources\TeamResource;
use App\Repository\TeamRepository;
use Illuminate\Http\JsonResponse;
use Sajya\Server\Procedure;

class TeamListProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'TeamListProcedure';

    private TeamRepository $operation;

    public function __construct(TeamRepository $operation) {
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
