<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Inviteds;

use App\Http\Requests\Inviteds\InvitedReadUserParticipantRequest;
use App\Http\Resources\Inviteds\InvitedResource;
use App\Repository\InvitedRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Sajya\Server\Procedure;

class InvitedReadUserParticipantProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'InvitedReadUserParticipantProcedure';
    private InvitedRepository $invitedRepository;

    public function __construct(InvitedRepository $invitedRepository)
    {
        $this->invitedRepository = $invitedRepository;
    }

    /**
     * Execute the procedure.
     *
     * @param InvitedReadUserParticipantRequest $request
     *
     * @return JsonResponse
     */
    public function handle(InvitedReadUserParticipantRequest $request): JsonResponse
    {
        $invites = $request->validated();
        return new JsonResponse(
            data: new InvitedResource(
                $this->invitedRepository->findByUserId($invites)
            ),
            status: Response::HTTP_CREATED
        );
    }
}
