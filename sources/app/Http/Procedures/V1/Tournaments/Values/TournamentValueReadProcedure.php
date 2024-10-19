<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Tournaments\Values;

use App\Domain\Abstracts\AbstractProcedure;
use App\Http\Requests\TournamentValues\TournamentValueReadRequest;
use App\Http\Resources\TournamentValues\TournamentValueResource;
use App\Repository\TournamentValueRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

require_once dirname(__DIR__, 5) . '/Domain/Constants/ProcedureNameConst.php';
require_once dirname(__DIR__, 5) . '/Domain/Constants/FieldConst.php';

class TournamentValueReadProcedure extends AbstractProcedure
{
    public static string $name = PROCEDURE_TOURNAMENT_VALUE_READ;
    private TournamentValueRepository $tournamentValueRepository;
    public function __construct(TournamentValueRepository $tournamentValueRepository)
    {
        $this->tournamentValueRepository = $tournamentValueRepository;
    }

    /**
     * @param TournamentValueReadRequest $request
     * @return JsonResponse
     */
    public function handle(TournamentValueReadRequest $request): JsonResponse
    {
        define("ATTRIBUTES", $request->validated());
        $repository = $this->tournamentValueRepository->findById(ATTRIBUTES[FIELD_ID]);
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
