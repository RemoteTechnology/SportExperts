<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Events\Filter;

use App\Domain\Abstracts\AbstractFilter;
use App\Http\Requests\Filter\ParticipantFilterRequest;
use App\Http\Resources\Events\EventCollection;
use App\Repository\Filter\Entities\Events\EventOwnerFilterRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

require_once dirname(__DIR__, 5) . '/Domain/Constants/ProcedureNameConst.php';
require_once dirname(__DIR__, 5) . '/Domain/Constants/FieldConst.php';

class EventOwnerFilterProcedure extends AbstractFilter
{
    public static string $name = PROCEDURE_EVENT_FILTER_EVENT_OWNER;
    private EventOwnerFilterRepository $filterRepository;

    public function __construct(EventOwnerFilterRepository $filterRepository)
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
        $repository = $this->filterRepository->filter(
            $format,
            ATTRIBUTES[FIELD_LIMIT],
            key_exists(FIELD_START_DATE, ATTRIBUTES) ? ATTRIBUTES[FIELD_START_DATE] : false,
            key_exists(FIELD_STATUS, ATTRIBUTES) ? ATTRIBUTES[FIELD_STATUS] : null,
        );
        $collectData = new EventCollection($repository);

        return new JsonResponse(
            data: [
                FIELD_ATTRIBUTES => $collectData->resource
            ],
            status: Response::HTTP_CREATED
        );
    }
}
