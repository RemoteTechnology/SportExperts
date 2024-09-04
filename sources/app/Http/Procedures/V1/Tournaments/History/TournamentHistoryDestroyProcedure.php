<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Tournaments\History;

use App\Http\Requests\TournamentHistory\TournamentHistoryReadRequest;
use App\Http\Resources\TournamentHistory\TournamentHistoryResource;
use App\Repository\TournamentHistoryActionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Sajya\Server\Procedure;

require_once dirname(__DIR__, 5) . '/Domain/Constants/ErrorMessageConst.php';

class TournamentHistoryDestroyProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'TournamentHistoryDestroyProcedure';
    private TournamentHistoryActionRepository $tournamentHistoryActionRepository;
    public function __construct(TournamentHistoryActionRepository $tournamentHistoryActionRepository)
    {
        $this->tournamentHistoryActionRepository = $tournamentHistoryActionRepository;
    }

    /**
     * TournamentHistoryDestroyProcedure the handle.
     *
     * @param TournamentHistoryReadRequest $request
     *
     * @return JsonResponse
     */
    public function handle(TournamentHistoryReadRequest $request): JsonResponse
    {
        define("ATTRIBUTES", $request->validated());
        $entity = $this->tournamentHistoryActionRepository->findById(ATTRIBUTES['id']);
        if ($this->tournamentHistoryActionRepository->destroy($entity))
        {
            return new JsonResponse(
                data: new TournamentHistoryResource($entity),
                status: Response::HTTP_CREATED
            );
        }
        return new JsonResponse(
            data: MESSAGE_NOT_DESTROY,
            status: Response::HTTP_CREATED
        );
    }
}
