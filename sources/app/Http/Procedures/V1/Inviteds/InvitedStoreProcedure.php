<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Inviteds;

use App\Http\Requests\Inviteds\InviteStoreRequest;
use App\Http\Resources\Inviteds\InvitedResource;
use App\Repository\InvitedRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Sajya\Server\Procedure;

class InvitedStoreProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'InvitedStoreProcedure';

    private InvitedRepository $invitedRepository;
    public function __construct(InvitedRepository $invitedRepository)
    {
        $this->invitedRepository = $invitedRepository;
    }

    /**
     * Execute the procedure.
     *
     * @param InviteStoreRequest $request
     *
     * @return JsonResponse
     */
    public function handle(InviteStoreRequest $request): JsonResponse
    {
        $invite = $request->validated();
        return  new JsonResponse(
            data: new InvitedResource(
                $this->invitedRepository->store($invite)
            ),
            status: 201
        );
    }
}
