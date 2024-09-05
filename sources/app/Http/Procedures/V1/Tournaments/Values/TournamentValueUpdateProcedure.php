<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Tournaments\Values;

use App\Http\Requests\TournamentValues\TournamentValueUpdateRequest;
use App\Http\Resources\TournamentValues\TournamentValueResource;
use App\Repository\TournamentValueRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Sajya\Server\Procedure;

class TournamentValueUpdateProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'TournamentValueUpdateProcedure';
    private TournamentValueRepository $tournamentValueRepository;
    public function __construct(TournamentValueRepository $tournamentValueRepository)
    {
        $this->tournamentValueRepository = $tournamentValueRepository;
    }

    /**
     * Execute the procedure.
     *
     * @param TournamentValueUpdateRequest $request
     *
     * @return JsonResponse
     */
    public function handle(TournamentValueUpdateRequest $request): JsonResponse
    {
        define("ATTRIBUTES", $request->validated());
        $entity = $this->tournamentValueRepository->findById(ATTRIBUTES['id']);
        $repository = $this->tournamentValueRepository->update($entity, ATTRIBUTES);

        return new JsonResponse(
            data: new TournamentValueResource($repository),
            status: Response::HTTP_CREATED
        );
    }
}
