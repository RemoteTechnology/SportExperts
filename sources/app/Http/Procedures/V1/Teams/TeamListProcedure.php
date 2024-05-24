<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Teams;

use App\Http\Resources\Teams\TeamCollection;
use App\Http\Resources\Teams\TeamResource;
use App\Models\Team;
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
        $teams = new TeamCollection($this->operation->list('paginate'));
        return new JsonResponse(
            data: $teams->resource,
            status: 201
        );
    }
}
