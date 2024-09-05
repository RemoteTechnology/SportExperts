<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Tournaments\Admin;

use App\Http\Requests\TournamentAdmin\TournamentAdminReadRequest;
use App\Http\Resources\TournamentAdmin\TournamentAdminResource;
use App\Repository\TournamentAdminRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Sajya\Server\Procedure;

class TournamentAdminReadProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'TournamentAdminReadProcedure';
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
        $repository = $this->tournamentAdminRepository->findById(ATTRIBUTES['id']);

        return new JsonResponse(
            data: new TournamentAdminResource($repository),
            status: Response::HTTP_CREATED
        );
    }
}
