<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Tournaments\Values;

use App\Domain\Abstracts\AbstractProcedure;
use App\Http\Requests\TournamentValues\TournamentValueUpdateRequest;
use App\Http\Resources\TournamentValues\TournamentValueResource;
use App\Repository\TournamentValueRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TournamentValueUpdateProcedure extends AbstractProcedure
{
    public static string $name = 'TournamentValueUpdateProcedure';
    private TournamentValueRepository $tournamentValueRepository;
    public function __construct(TournamentValueRepository $tournamentValueRepository)
    {
        $this->tournamentValueRepository = $tournamentValueRepository;
    }

    /**
     * @param TournamentValueUpdateRequest $request
     * @return JsonResponse
     */
    public function handle(TournamentValueUpdateRequest $request): JsonResponse
    {
        define("ATTRIBUTES", $request->validated());
        $entity = $this->tournamentValueRepository->findById(ATTRIBUTES['id']);
        $repository = $this->tournamentValueRepository->update($entity, ATTRIBUTES);

        return new JsonResponse(
            data: [
                FIELD_ID => self::identifier(),
                FIELD_ATTRIBUTES => new TournamentValueResource($repository),
                ...self::meta($request, ATTRIBUTES)
            ],
            status: Response::HTTP_CREATED
        );
    }
}
