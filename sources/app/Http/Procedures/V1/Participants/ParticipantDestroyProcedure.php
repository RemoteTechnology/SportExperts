<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Participants;

use App\Domain\Abstracts\AbstractProcedure;
use App\Domain\Interfaces\Repositories\Entities\ParticipantRepositoryInterface;
use App\Http\Requests\Participants\ReadParticipantRequest;
use App\Http\Resources\Participants\ParticipantResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ParticipantDestroyProcedure extends AbstractProcedure
{
    public static string $name = PROCEDURE_PARTICIPANT_DESTROY;
    private ParticipantRepositoryInterface $participantRepository;

    public function __construct(ParticipantRepositoryInterface $participantRepository) {
        $this->participantRepository = $participantRepository;
    }

    /**
     * @param ReadParticipantRequest $request
     * @return JsonResponse
     */
    public function handle(ReadParticipantRequest $request): JsonResponse
    {
        define('ATTRIBUTES', $request->validated());
        $participant = $this->participantRepository->findById(ATTRIBUTES[FIELD_ID]);
        $repository = $this->participantRepository->destroy($participant);

        return new JsonResponse(
            data: [
                FIELD_ID => self::identifier(),
                FIELD_ATTRIBUTES => new ParticipantResource($repository),
                ...self::meta($request, ATTRIBUTES)
            ],
            status: Response::HTTP_CREATED
        );
    }
}
