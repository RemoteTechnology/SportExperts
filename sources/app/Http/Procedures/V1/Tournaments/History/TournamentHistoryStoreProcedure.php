<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Tournaments\History;

use App\Domain\Abstracts\AbstractProcedure;
use App\Http\Requests\TournamentHistory\TournamentHistoryStoreRequest;
use App\Http\Resources\TournamentHistory\TournamentHistoryResource;
use App\Repository\TournamentHistoryActionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TournamentHistoryStoreProcedure extends AbstractProcedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'TournamentHistoryStoreProcedure';
    private TournamentHistoryActionRepository $tournamentHistoryActionRepository;
    public function __construct(TournamentHistoryActionRepository $tournamentHistoryActionRepository)
    {
        $this->tournamentHistoryActionRepository = $tournamentHistoryActionRepository;
    }

    /**
     * TournamentHistoryStoreProcedure the handle.
     *
     * @param TournamentHistoryStoreRequest $request
     *
     * @return JsonResponse
     */
    public function handle(TournamentHistoryStoreRequest $request): JsonResponse
    {
        define("ATTRIBUTES", $request->validated());
        $repository = $this->tournamentHistoryActionRepository->store(ATTRIBUTES);

        return new JsonResponse(
            data: [
                FIELD_ID => self::identifier(),
                FIELD_ATTRIBUTES => new TournamentHistoryResource($repository),
                ...self::meta($request, ATTRIBUTES)
            ],
            status: Response::HTTP_CREATED
        );
    }
}
