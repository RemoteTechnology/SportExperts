<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Events\Filter;

use App\Domain\Abstracts\AbstractFilter;
use App\Http\Requests\Filter\ParticipantFilterRequest;
use App\Http\Resources\Events\EventCollection;
use App\Http\Resources\Events\EventResource;
use App\Repository\Filter\EventToParticipantFilterRepository;
use Illuminate\Http\JsonResponse;

class EventDateFilterProcedure extends AbstractFilter
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'EventDateFilterProcedure';

    private EventToParticipantFilterRepository $filterRepository;
    public function __construct(EventToParticipantFilterRepository $filterRepository)
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
    public function handle(ParticipantFilterRequest $request)//: JsonResponse
    {
        $data = $request->validated();

        if ($data['mode'] === 'after')
        {
            $query = $this->filterRepository->filterAfterDate($this->formatDate($data), $data['limit'])->all()['data'];
            $events = new EventCollection($query);
            return new JsonResponse(
                data: $events->resource,
                status: 201
            );
        }
        elseif ($data['mode'] === 'before')
        {
            $query = $this->filterRepository->filterBeforeDate($this->formatDate($data), $data['limit'])->all()['data'];
            $events = new EventCollection($query);
            return new JsonResponse(
                data: $events->resource,
                status: 201
            );
        }
        else
        {
            $query = $this->filterRepository->filterDate($this->formatDate($data), $data['limit'])->all()['data'];
            $events = new EventCollection($query);
            return new JsonResponse(
                data: $events->resource,
                status: 201
            );
        }
    }
}
