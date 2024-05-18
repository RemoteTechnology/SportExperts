<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Participants;

use App\Domain\Interfaces\Repositories\Entities\ParticipantRepositoryInterface;
use App\Http\Requests\Participants\StoreParticipantReqest;
use App\Http\Resources\ParticipantResource;
use Illuminate\Http\JsonResponse;
use Sajya\Server\Procedure;

class ParticipantStoreProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'ParticipantStoreProcedure';

    private ParticipantRepositoryInterface $operation;

    public function __construct(ParticipantRepositoryInterface $operation) {
        $this->operation = $operation;
    }

    /**
     * Execute the procedure.
     *
     * @param StoreParticipantReqest $request
     *
     * @return JsonResponse
     */
    public function handle(StoreParticipantReqest $request): JsonResponse
    {
        return new JsonResponse(
            data: new ParticipantResource(
                $request->validated()
            ),
            status: 201
        );
    }
}
