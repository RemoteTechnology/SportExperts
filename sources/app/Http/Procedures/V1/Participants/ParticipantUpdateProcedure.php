<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Participants;

use App\Domain\Interfaces\Repositories\Entities\ParticipantRepositoryInterface;
use App\Http\Requests\Participants\UpdateParticipantReqest;
use App\Http\Resources\ParticipantResource;
use Illuminate\Http\JsonResponse;
use Sajya\Server\Procedure;

class ParticipantUpdateProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'ParticipantUpdateProcedure';

    private ParticipantRepositoryInterface $operation;

    public function __construct(ParticipantRepositoryInterface $operation) {
        $this->operation = $operation;
    }

    /**
     * Execute the procedure.
     *
     * @param UpdateParticipantReqest $request
     *
     * @return JsonResponse
     */
    public function handle(UpdateParticipantReqest $request): JsonResponse
    {
        $participant = $request->validated();
        return new JsonResponse(
            data: new ParticipantResource(
                $this->operation->update(
                    $this->operation->findById($participant['id']),
                    $participant
                )
            ),
            status: 201
        );
    }
}