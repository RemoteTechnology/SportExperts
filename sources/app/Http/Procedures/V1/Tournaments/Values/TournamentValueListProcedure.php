<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Tournaments\Values;

use App\Http\Requests\TournamentValues\TournamentValueListRequest;
use App\Http\Resources\TournamentValues\TournamentValueCollection;
use App\Repository\TournamentValueRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Sajya\Server\Procedure;

class TournamentValueListProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'TournamentValueListProcedure';
    private TournamentValueRepository $tournamentValueRepository;
    public function __construct(TournamentValueRepository $tournamentValueRepository)
    {
        $this->tournamentValueRepository = $tournamentValueRepository;
    }

    /**
     * TournamentValueListProcedure the handle.
     *
     * @param TournamentValueListRequest $request
     *
     * @return JsonResponse
     */
    public function handle(TournamentValueListRequest $request): JsonResponse
    {
        define("ATTRIBUTES", $request->validated());
        $repository = $this->tournamentValueRepository->list();
        $dataCollection = new TournamentValueCollection($repository);

        return new JsonResponse(
            data: $dataCollection->resource,
            status: Response::HTTP_CREATED
        );
    }
}
