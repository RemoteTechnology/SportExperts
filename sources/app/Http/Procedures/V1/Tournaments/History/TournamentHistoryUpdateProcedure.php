<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Tournaments\History;

use App\Http\Requests\TournamentHistory\TournamentHistoryUpdateRequest;
use App\Http\Resources\TournamentHistory\TournamentHistoryResource;
use App\Repository\TournamentHistoryActionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Sajya\Server\Procedure;

class TournamentHistoryUpdateProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'TournamentHistoryUpdateProcedure';
    private TournamentHistoryActionRepository $tournamentHistoryActionRepository;
    public function __construct(TournamentHistoryActionRepository $tournamentHistoryActionRepository)
    {
        $this->tournamentHistoryActionRepository = $tournamentHistoryActionRepository;
    }

    /**
     * TournamentHistoryUpdateProcedure the handle.
     *
     * @param TournamentHistoryUpdateRequest $request
     *
     * @return JsonResponse
     */
    public function handle(TournamentHistoryUpdateRequest $request): JsonResponse
    {
        define("ATTRIBUTES", $request->validated());
        $entity = $this->tournamentHistoryActionRepository->findById(ATTRIBUTES['id']);
        $repository = $this->tournamentHistoryActionRepository->update($entity, ATTRIBUTES);

        return new JsonResponse(
            data: new TournamentHistoryResource($repository),
            status: Response::HTTP_CREATED
        );
    }
}
