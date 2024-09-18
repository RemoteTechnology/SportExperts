<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Tournaments\Values;

use App\Domain\Abstracts\AbstractProcedure;
use App\Http\Requests\TournamentValues\TournamentValueListRequest;
use App\Http\Resources\TournamentValues\TournamentValueCollection;
use App\Repository\TournamentValueRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TournamentValueListProcedure extends AbstractProcedure
{
    public static string $name = 'TournamentValueListProcedure';
    private TournamentValueRepository $tournamentValueRepository;
    public function __construct(TournamentValueRepository $tournamentValueRepository)
    {
        $this->tournamentValueRepository = $tournamentValueRepository;
    }

    /**
     * @param TournamentValueListRequest $request
     * @return JsonResponse
     */
    public function handle(TournamentValueListRequest $request): JsonResponse
    {
        define("ATTRIBUTES", $request->validated());
        $repository = $this->tournamentValueRepository->list();
        $dataCollection = new TournamentValueCollection($repository);

        return new JsonResponse(
            data: [
                FIELD_ID => self::identifier(),
                FIELD_ATTRIBUTES => $dataCollection->resource,
                ...self::meta($request, ATTRIBUTES)
            ],
            status: Response::HTTP_CREATED
        );
    }
}
