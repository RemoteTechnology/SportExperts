<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Tournaments\Admin;

use App\Http\Requests\TournamentAdmin\TournamentAdminUpdateRequest;
use App\Http\Resources\TournamentAdmin\TournamentAdminResource;
use App\Repository\TournamentAdminRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Sajya\Server\Procedure;

class TournamentAdminUpdateProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'TournamentAdminUpdateProcedure';
    private TournamentAdminRepository $tournamentAdminRepository;
    public function __construct(TournamentAdminRepository $tournamentAdminRepository)
    {
        $this->tournamentAdminRepository = $tournamentAdminRepository;
    }

    /**
     * TournamentAdminUpdateProcedure the handle.
     *
     * @param TournamentAdminUpdateRequest $request
     *
     * @return JsonResponse
     */
    public function handle(TournamentAdminUpdateRequest $request): JsonResponse
    {
        define("ATTRIBUTES", $request->validated());
        $entity = $this->tournamentAdminRepository->findById(ATTRIBUTES['id']);
        $repository = $this->tournamentAdminRepository->update($entity, ATTRIBUTES);

        return new JsonResponse(
            data: new TournamentAdminResource($repository),
            status: Response::HTTP_CREATED
        );
    }
}