<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Tournaments\Values;

use App\Domain\Abstracts\AbstractProcedure;
use App\Http\Requests\TournamentValues\TournamentValueReadRequest;
use App\Http\Resources\TournamentValues\TournamentValueResource;
use App\Repository\TournamentValueRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

require_once dirname(__DIR__, 5) . '/Domain/Constants/ErrorMessageConst.php';

class TournamentValueDestroyProcedure extends AbstractProcedure
{
    public static string $name = 'TournamentValueDestroyProcedure';
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
        $entity = $this->tournamentValueRepository->findById(ATTRIBUTES['id']);
        if ($this->tournamentValueRepository->destroy($entity))
        {
            return new JsonResponse(
                data: [
                    FIELD_ID => self::identifier(),
                    FIELD_ATTRIBUTES => new TournamentValueResource($entity),
                    ...self::meta($request, ATTRIBUTES)
                ],
                status: Response::HTTP_CREATED
            );
        }

        return new JsonResponse(
            data: [
                FIELD_ID => self::identifier(),
                FIELD_ATTRIBUTES => [
                    FIELD_MESSAGE => MESSAGE_NOT_DESTROY
                ],
                ...self::meta($request, ATTRIBUTES)
            ],
            status: Response::HTTP_CREATED
        );
    }
}
