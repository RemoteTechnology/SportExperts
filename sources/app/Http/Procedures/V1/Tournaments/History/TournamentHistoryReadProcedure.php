<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Tournaments\History;

use App\Http\Requests\TournamentHistory\TournamentHistoryReadRequest;
use App\Http\Resources\TournamentHistory\TournamentHistoryResource;
use App\Repository\TournamentHistoryActionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Sajya\Server\Procedure;

class TournamentHistoryReadProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'TournamentHistoryReadProcedure';
    private TournamentHistoryActionRepository $tournamentHistoryActionRepository;
    public function __construct(TournamentHistoryActionRepository $tournamentHistoryActionRepository)
    {
        $this->tournamentHistoryActionRepository = $tournamentHistoryActionRepository;
    }

    /**
     * TournamentHistoryReadProcedure the handle.
     *
     * @param TournamentHistoryReadRequest $request
     *
     * @return JsonResponse
     */
    public function handle(TournamentHistoryReadRequest $request): JsonResponse
    {
        define("ATTRIBUTES", $request->validated());
        $repository = $this->tournamentHistoryActionRepository->findById(ATTRIBUTES['id']);

        return new JsonResponse(
            data: new TournamentHistoryResource($repository),
            status: Response::HTTP_CREATED
        );
    }
}
