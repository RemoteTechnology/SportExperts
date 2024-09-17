<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Participants;

use App\Domain\Abstracts\AbstractProcedure;
use App\Http\Requests\Participants\UpdateParticipantReqest;
use App\Http\Resources\Participants\ParticipantResource;
use App\Repository\ParticipantRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Sajya\Server\Procedure;

require_once dirname(__DIR__, 4) . '/Domain/Constants/ProcedureNameConst.php';
require_once dirname(__DIR__, 4) . '/Domain/Constants/FieldConst.php';

class ParticipantUpdateProcedure extends AbstractProcedure
{
    public static string $name = PROCEDURE_PARTICIPANT_UPDATE;
    private ParticipantRepository $participantRepository;

    public function __construct(ParticipantRepository $participantRepository) {
        $this->participantRepository = $participantRepository;
    }

    /**
     * @param UpdateParticipantReqest $request
     * @return JsonResponse
     */
    public function handle(UpdateParticipantReqest $request): JsonResponse
    {
        define('ATTRIBUTES', $request->validated());
        $participant = $this->participantRepository->findById(ATTRIBUTES[FIELD_ID]);
        $repository = $this->participantRepository->update($participant, ATTRIBUTES);

        return new JsonResponse(
            data: [
                FIELD_ID => self::identifier(),
                FIELD_MESSAGE => new ParticipantResource($repository),
                ...self::meta($request, ATTRIBUTES)
            ],
            status: Response::HTTP_CREATED
        );
    }
}
