<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Events\Filter;

use App\Domain\Abstracts\AbstractFilter;
use App\Domain\Abstracts\AbstractProcedure;
use App\Domain\Constants\EnumConstants\FilterDateModeEnum;
use App\Http\Requests\Filter\ParticipantFilterRequest;
use App\Http\Resources\Events\EventCollection;
use App\Repository\Filter\Entities\Events\EventToParticipantFilterRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

require_once dirname(__DIR__, 5) . '/Domain/Constants/ProcedureNameConst.php';
require_once dirname(__DIR__, 5) . '/Domain/Constants/FieldConst.php';

class EventDateFilterProcedure extends AbstractFilter
{
    public static string $name = PROCEDURE_EVENT_FILTER_DATE;
    private EventToParticipantFilterRepository $filterRepository;

    public function __construct(EventToParticipantFilterRepository $filterRepository)
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

        if (ATTRIBUTES[FIELD_MODE] === FilterDateModeEnum::AFTER)
        {
            $format = $this->formatDate(ATTRIBUTES);
            $repository = $this->filterRepository->filterAfterDate($format, ATTRIBUTES[FIELD_LIMIT]);
            $collectData = new EventCollection($repository->all()[FIELD_DATA]);

            return new JsonResponse(
                data: [
                    FIELD_ATTRIBUTES => $collectData->resource,
                ],
                status: Response::HTTP_CREATED
            );
        }
        elseif (ATTRIBUTES[FIELD_MODE] === FilterDateModeEnum::BEFORE)
        {
            $format = $this->formatDate(ATTRIBUTES);
            $repository = $this->filterRepository->filterBeforeDate($format, ATTRIBUTES[FIELD_LIMIT]);
            $collectData = new EventCollection($repository->all()[FIELD_DATA]);

            return new JsonResponse(
                data: [
                    FIELD_ATTRIBUTES => $collectData->resource
                ],
                status: Response::HTTP_CREATED
            );
        }

        $format = $this->formatDate(ATTRIBUTES);
        $repository = $this->filterRepository->filterDate($format, ATTRIBUTES[FIELD_LIMIT]);
        $collectData = new EventCollection($repository);

        return new JsonResponse(
            data: [
                FIELD_ATTRIBUTES => $collectData->resource
            ],
            status: Response::HTTP_CREATED
        );
    }
}
