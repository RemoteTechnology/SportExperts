<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Participants;

use App\Http\Requests\Participants\StoreParticipantReqest;
use App\Http\Resources\Participants\ParticipantResource;
use App\Repository\ParticipantRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Sajya\Server\Procedure;

class ParticipantStoreProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'ParticipantStoreProcedure';

    private ParticipantRepository $operation;

    public function __construct(ParticipantRepository $operation) {
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
        $participant = $request->validated();
        $participant['key'] = Str::uuid()->toString();
        return new JsonResponse(
            data: new ParticipantResource(
                $this->operation->store($participant)
            ),
            status: 201
        );
    }
}
