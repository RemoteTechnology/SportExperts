<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Participants\Filter;

use App\Http\Requests\Filter\ParticipantsUserToEventFilterRequest;
use App\Http\Resources\Participants\ParticipantCollection;
use App\Repository\ParticipantRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Sajya\Server\Procedure;

class ParticipantUsersToEventFilterProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'ParticipantUsersToEventFilterProcedure';
    private ParticipantRepository $participantRepository;

    public function __construct(ParticipantRepository $participantRepository)
    {
        $this->participantRepository = $participantRepository;
    }

    /**
     * Execute the procedure.
     *
     * @param ParticipantsUserToEventFilterRequest $request
     *
     * @return JsonResponse
     */
    public function handle(ParticipantsUserToEventFilterRequest $request)
    {
        $attributes = $request->validated();
        $participants = new ParticipantCollection(
            $this->participantRepository->findByEventKey($attributes['event_key'])
        );
        return new JsonResponse(
            data: $participants->resource,
//            data: $this->participantRepository->findByEventKey($attributes['event_key']),
            status: Response::HTTP_CREATED
        );
    }
}
