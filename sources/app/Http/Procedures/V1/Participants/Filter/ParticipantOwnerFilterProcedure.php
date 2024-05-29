<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Participants\Filter;

use App\Domain\Abstracts\AbstractFilter;
use App\Http\Requests\Filter\ParticipantFilterRequest;
use App\Repository\Filter\ParticipantOwnerFilterRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Sajya\Server\Procedure;

class ParticipantOwnerFilterProcedure extends AbstractFilter
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'ParticipantOwnerFilterProcedure';

    private ParticipantOwnerFilterRepository $filterRepository;

    public function __construct(ParticipantOwnerFilterRepository $filterRepository)
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

        return new JsonResponse(
            data: $this->filterRepository->filter($this->formatDate($data), $data['limit']),
            status: 201
        );
    }
}
