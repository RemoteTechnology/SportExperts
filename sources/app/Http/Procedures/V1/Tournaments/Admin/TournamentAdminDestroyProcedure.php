<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Tournaments\Admin;

use App\Http\Requests\TournamentAdmin\TournamentAdminReadRequest;
use App\Http\Resources\TournamentAdmin\TournamentAdminResource;
use App\Repository\TournamentAdminRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Sajya\Server\Procedure;

require_once dirname(__DIR__, 5) . '/Domain/Constants/ErrorMessageConst.php';

class TournamentAdminDestroyProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'TournamentAdminDestroyProcedure';
    private TournamentAdminRepository $tournamentAdminRepository;
    public function __construct(TournamentAdminRepository $tournamentAdminRepository)
    {
        $this->tournamentAdminRepository = $tournamentAdminRepository;
    }

    /**
     * TournamentAdminUpdateProcedure the handle.
     *
     * @param TournamentAdminReadRequest $request
     *
     * @return JsonResponse
     */
    public function handle(TournamentAdminReadRequest $request): JsonResponse
    {
        define("ATTRIBUTES", $request->validated());
        $entity = $this->tournamentAdminRepository->findById(ATTRIBUTES['id']);
        if ($this->tournamentAdminRepository->destroy($entity))
        {
            return new JsonResponse(
                data: new TournamentAdminResource($entity),
                status: Response::HTTP_CREATED
            );
        }

        return new JsonResponse(
            data: MESSAGE_NOT_DESTROY,
            status: Response::HTTP_CREATED
        );
    }
}