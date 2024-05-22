<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Participants;

use App\Http\Requests\Participants\ReadParticipantRequest;
use App\Http\Resources\ParticipantResource;
use App\Repository\ParticipantRepository;
use Illuminate\Http\JsonResponse;
use Sajya\Server\Procedure;

class ParticipantReadProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'ParticipantReadProcedure';

    private ParticipantRepository $operation;

    public function __construct(ParticipantRepository $operation) {
        $this->operation = $operation;
    }

    /**
     * Execute the procedure.
     *
     * @param ReadParticipantRequest $request
     *
     * @return JsonResponse
     */
    public function handle(ReadParticipantRequest $request): JsonResponse
    {
        $participant = $request->validated();
        return new JsonResponse(
            data: new ParticipantResource(
                $this->operation->findById($participant['id'])
            ),
            status: 201
        );
    }
}
