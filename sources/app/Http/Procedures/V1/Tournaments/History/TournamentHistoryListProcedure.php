<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Tournaments\History;

use App\Http\Resources\TournamentHistory\TournamentHistorCollection;
use App\Repository\TournamentHistoryActionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Sajya\Server\Procedure;

class TournamentHistoryListProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'TournamentHistoryListProcedure';
    private TournamentHistoryActionRepository $tournamentHistoryActionRepository;
    public function __construct(TournamentHistoryActionRepository $tournamentHistoryActionRepository)
    {
        $this->tournamentHistoryActionRepository = $tournamentHistoryActionRepository;
    }

    /**
     * TournamentHistoryListProcedure the handle.
     *
     * @param TournamentHistoryListProcedure $request
     *
     * @return JsonResponse
     */
    public function handle(TournamentHistoryListProcedure $request): JsonResponse
    {
        define("ATTRIBUTES", $request->validated());
        $repository = $this->tournamentHistoryActionRepository->list();
        $dataCollection = new TournamentHistorCollection($repository);

        return new JsonResponse(
            data: $dataCollection->resource,
            status: Response::HTTP_CREATED
        );
    }
}
