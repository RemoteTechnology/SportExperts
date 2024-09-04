<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Tournaments\Admin;

use App\Http\Requests\TournamentAdmin\TournamentAdminStoreRequest;
use App\Http\Resources\Tournaments\TournamentResource;
use App\Repository\TournamentAdminRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Sajya\Server\Procedure;

class TournamentAdminStoreProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'TournamentAdminStoreProcedure';
    private TournamentAdminRepository $tournamentAdminRepository;
    public function __construct(TournamentAdminRepository $tournamentAdminRepository)
    {
        $this->tournamentAdminRepository = $tournamentAdminRepository;
    }

    /**
     * TournamentAdminStoreProcedure the handle.
     *
     * @param TournamentAdminStoreRequest $request
     *
     * @return JsonResponse
     */
    public function handle(TournamentAdminStoreRequest $request): JsonResponse
    {
        define("ATTRIBUTES", $request->validated());
        $repository = $this->tournamentAdminRepository->store(ATTRIBUTES);

        return new JsonResponse(
            data: new TournamentResource($repository),
            status: Response::HTTP_CREATED
        );
    }
}
