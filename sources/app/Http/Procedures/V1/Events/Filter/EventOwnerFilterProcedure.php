<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Events\Filter;

use App\Domain\Abstracts\AbstractFilter;
use App\Http\Requests\Filter\ParticipantFilterRequest;
use App\Http\Resources\Events\EventCollection;
use App\Repository\Filter\EventOwnerFilterRepository;
use Illuminate\Http\JsonResponse;

class EventOwnerFilterProcedure extends AbstractFilter
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'EventOwnerFilterProcedure';
    private EventOwnerFilterRepository $filterRepository;

    public function __construct(EventOwnerFilterRepository $filterRepository)
    {
        $this->filterRepository = $filterRepository;
    }

    /**
     * Execute the procedure.
     *
     * @param ParticipantFilterRequest $request
     *
     * @return JsonResponse
     */
    public function handle(ParticipantFilterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $events = new EventCollection($this->filterRepository->filter(
            $this->formatDate($data),
            $data['limit'],
            key_exists('start_date', $data) ? $data['start_date'] : false,
            key_exists('status', $data) ? $data['status'] : null,
        ));

        return new JsonResponse(
            data: $events->resource,
            status: 201
        );
    }
}
