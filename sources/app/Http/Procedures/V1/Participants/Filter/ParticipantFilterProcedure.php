<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Participants\Filter;

use App\Http\Requests\Filter\ParticipantFilterRequest;
use App\Http\Resources\Events\EventCollection;
use App\Repository\Filter\ProceduresFilterRepository;
use Illuminate\Http\JsonResponse;
use Sajya\Server\Procedure;

class ParticipantFilterProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'ParticipantFilterProcedure';

    private ProceduresFilterRepository $filterRepository;
    public function __construct(ProceduresFilterRepository $filterRepository)
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
        $dataValidate = $request->validated();
        $data = [];
        $filter = explode(',', str_replace(' ', '', $dataValidate['filter']));
        foreach ($filter as $item) {
            list($key, $value) = explode(':', $item);
            $data[$key] = $value;
        }
        if ($dataValidate['mode'] === 'after')
        {
            return new JsonResponse(
                data: $this->filterRepository->filterAfterDate($data, $dataValidate['limit']),
                status: 201
            );
        }
        elseif ($dataValidate['mode'] === 'before')
        {
            return new JsonResponse(
                data: $this->filterRepository->filterBeforeDate($data, $dataValidate['limit']),
                status: 201
            );
        }
        else
        {
            return new JsonResponse(
                data: $this->filterRepository->filterDate($data, $dataValidate['limit']),
                status: 201
            );
        }
    }
}
