<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Participants;

use App\Http\Requests\Participants\StoreParticipantReqest;
use App\Http\Resources\Participants\ParticipantResource;
use App\Repository\ParticipantRepository;
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

    private ParticipantRepository $participantRepository;

    public function __construct(ParticipantRepository $participantRepository) {
        $this->participantRepository = $participantRepository;
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
        // TODO: пока оставить так, но потом сделать как в InvitedStoreProcedure:44!
        foreach ($this->participantRepository->filter($participant['user_id']) as $value)
        {
            if ($value->event_id === $participant['event_id'])
            {
                return new JsonResponse(
                    data: ALREADY_PARTICIPANT,
                    status: 201
                );
            }
        }
        return new JsonResponse(
            data: new ParticipantResource(
                $this->participantRepository->store($participant)
            ),
            status: 201
        );
    }
}
