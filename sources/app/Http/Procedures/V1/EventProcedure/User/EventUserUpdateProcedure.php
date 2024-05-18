<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\EventProcedure\User;

use App\Domain\Interfaces\Repositories\Entities\EventUserRepositoryInterface;
use App\Domain\Interfaces\Repositories\LCRUD_OperationInterface;
use App\Http\Requests\Participants\StoreParticipantReqest;
use App\Http\Requests\Participants\UpdateParticipantReqest;
use App\Http\Resources\ParticipantResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Sajya\Server\Procedure;

class EventUserUpdateProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'EventUserUpdateProcedure';

    private EventUserRepositoryInterface $operation;

    public function __construct(EventUserRepositoryInterface $operation) {
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
