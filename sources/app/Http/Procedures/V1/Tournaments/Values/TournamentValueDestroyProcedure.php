<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Tournaments\Values;

use App\Http\Requests\TournamentValues\TournamentValueReadRequest;
use App\Http\Resources\TournamentValues\TournamentValueResource;
use App\Repository\TournamentValueRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Sajya\Server\Procedure;

require_once dirname(__DIR__, 5) . '/Domain/Constants/ErrorMessageConst.php';

class TournamentValueDestroyProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'TournamentValueDestroyProcedure';
    private TournamentValueRepository $tournamentValueRepository;
    public function __construct(TournamentValueRepository $tournamentValueRepository)
    {
        $this->tournamentValueRepository = $tournamentValueRepository;
    }

    /**
     * TournamentValueDestroyProcedure the handle.
     *
     * @param TournamentValueReadRequest $request
     *
     * @return JsonResponse
     */
    public function handle(TournamentValueReadRequest $request): JsonResponse
    {
        define("ATTRIBUTES", $request->validated());
        $entity = $this->tournamentValueRepository->findById(ATTRIBUTES['id']);
        if ($this->tournamentValueRepository->destroy($entity))
        {
            return new JsonResponse(
                data: new TournamentValueResource($entity),
                status: Response::HTTP_CREATED
            );
        }

        return new JsonResponse(
            data: MESSAGE_NOT_DESTROY,
            status: Response::HTTP_CREATED
        );
    }
}
