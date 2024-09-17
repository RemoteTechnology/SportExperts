<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Participants;

use App\Domain\Abstracts\AbstractProcedure;
use App\Http\Resources\Participants\ParticipantCollection;
use App\Repository\ParticipantRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

require_once dirname(__DIR__, 4) . '/Domain/Constants/ProcedureNameConst.php';
require_once dirname(__DIR__, 4) . '/Domain/Constants/FieldConst.php';

class ParticipantListProcedure extends AbstractProcedure
{
    public static string $name = PROCEDURE_PARTICIPANT_LIST;
    private ParticipantRepository $participantRepository;

    public function __construct(ParticipantRepository $participantRepository) {
        $this->participantRepository = $participantRepository;
    }

    /**
     * @return JsonResponse
     */
    public function handle(Request $request): JsonResponse
    {
        $repository = $this->participantRepository->list(FIELD_PAGINATE);
        $collectData = new ParticipantCollection($repository);

        return new JsonResponse(
            data: [
                FIELD_ID => self::identifier(),
                FIELD_ATTRIBUTES => $collectData->resource,
                ...self::meta($request, [])
            ],
            status: Response::HTTP_CREATED
        );
    }
}
