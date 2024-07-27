<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Participants;

use App\Http\Requests\Participants\StoreParticipantReqest;
use App\Http\Resources\Participants\ParticipantResource;
use App\Repository\ParticipantRepository;
use App\Services\Tournaments\AlgorithmRanging;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Sajya\Server\Procedure;

require_once dirname(__DIR__, 4) . '/Domain/Constants/ParticipantMessageConst.php';

class ParticipantStoreProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'ParticipantStoreProcedure';

    private AlgorithmRanging $algorithmRanging;
    private ParticipantRepository $participantRepository;

    public function __construct(ParticipantRepository $participantRepository, AlgorithmRanging $algorithmRanging) {
        $this->participantRepository = $participantRepository;
        $this->algorithmRanging = $algorithmRanging;
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
        $participant['event_id'] = (integer)$participant['event_id'];
        $participant['user_id'] = (integer)$participant['user_id'];
        $participant['invited_user_id'] = (integer)$participant['invited_user_id'];
        $participant['key'] = Str::uuid()->toString();
        // TODO: пока оставить так, но потом сделать как в InvitedStoreProcedure:44!
        foreach ($this->participantRepository->userList($participant['event_id']) as $value)
        {
            if ($value->user_id === $participant['user_id'])
            {
                return new JsonResponse(
                    data: ALREADY_PARTICIPANT,
                    status: 201
                );
            }
        }

        $participantStore = $this->participantRepository->store($participant);
        $this->algorithmRanging->ranging($participantStore->key);

        return new JsonResponse(
            data: $participantStore,
            status: 201
        );
    }
}
