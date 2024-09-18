<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Participants\Filter;

use App\Domain\Abstracts\AbstractFilter;
use App\Http\Requests\Filter\ParticipantFilterRequest;
use App\Repository\Filter\Entities\Participants\ParticipantOwnerFilterRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

require_once dirname(__DIR__, 5) . '/Domain/Constants/ProcedureNameConst.php';
require_once dirname(__DIR__, 5) . '/Domain/Constants/FieldConst.php';

class ParticipantOwnerFilterProcedure extends AbstractFilter
{
    public static string $name = PROCEDURE_PARTICIPANT_FILTER_PARTICIPANT_OWNER;
    private ParticipantOwnerFilterRepository $filterRepository;

    public function __construct(ParticipantOwnerFilterRepository $filterRepository)
    {
        $this->filterRepository = $filterRepository;
    }

    /**
     * @param ParticipantFilterRequest $request
     * @return JsonResponse
     */
    public function handle(ParticipantFilterRequest $request): JsonResponse
    {
        define('ATTRIBUTES', $request->validated());
        $format = $this->formatDate(ATTRIBUTES);
        $repository = $this->filterRepository->filter($format, ATTRIBUTES[FIELD_LIMIT]);

        return new JsonResponse(
            data: [
                FIELD_ATTRIBUTES => $repository
            ],
            status: Response::HTTP_CREATED
        );
    }
}
