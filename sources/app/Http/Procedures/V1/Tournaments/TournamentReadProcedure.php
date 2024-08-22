<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Tournaments;

use App\Http\Requests\Tournaments\TournamentReadRequest;
use App\Http\Resources\Tournaments\TournamentResource;
use App\Http\Resources\TournamentValues\TournamentValueCollection;
use App\Repository\TournamentRepository;
use App\Repository\TournamentValueRepository;
use App\Services\GridTournamentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Sajya\Server\Procedure;

class TournamentReadProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'TournamentReadProcedure';

    private TournamentRepository $tournamentRepository;
    private TournamentValueRepository $tournamentValueRepository;

    public function __construct(
        TournamentRepository $tournamentRepository,
        TournamentValueRepository $tournamentValueRepository
    )
    {
        $this->tournamentRepository = $tournamentRepository;
        $this->tournamentValueRepository = $tournamentValueRepository;
    }

    /**
     * Execute the procedure.
     *
     * @param TournamentReadRequest $request
     *
     * @return JsonResponse
     */
    public function handle(TournamentReadRequest $request)
    {
        $data = $request->validated();
        $tournament = $this->tournamentRepository->findByTournamentKey($data['event_key']);
        $values = new TournamentValueCollection(
            $this->tournamentValueRepository->findByTournamentValue($tournament->id)
        );

        return new JsonResponse(
            data: [
                'tournament'    => new TournamentResource($tournament),
                'values'        => $values->resource,
            ],
            status: Response::HTTP_CREATED
        );
    }
}
