<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Tournaments\Values;

use App\Http\Requests\TournamentValues\TournamentValueReadRequest;
use App\Http\Resources\TournamentValues\TournamentValueResource;
use App\Repository\TournamentValueRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Sajya\Server\Procedure;

class TournamentValueReadProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'TournamentValueReadProcedure';
    private TournamentValueRepository $tournamentValueRepository;
    public function __construct(TournamentValueRepository $tournamentValueRepository)
    {
        $this->tournamentValueRepository = $tournamentValueRepository;
    }

    /**
     * TournamentValueReadProcedure the handle.
     *
     * @param TournamentValueReadRequest $request
     *
     * @return JsonResponse
     */
    public function handle(TournamentValueReadRequest $request): JsonResponse
    {
        define("ATTRIBUTES", $request->validated());
        $repository = $this->tournamentValueRepository->findById(ATTRIBUTES['id']);
        return new JsonResponse(
            data: new TournamentValueResource($repository),
            status: Response::HTTP_CREATED
        );
    }
}
