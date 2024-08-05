<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Inviteds;

use App\Http\Requests\Inviteds\ReadInvitedRequest;
use App\Http\Resources\Inviteds\InvitedResource;
use App\Repository\InvitedRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Sajya\Server\Procedure;

class InvitedReadProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'InvitedReadProcedure';
    private InvitedRepository $operation;

    public function __construct(InvitedRepository $operation) {
        $this->operation = $operation;
    }

    /**
     * Execute the procedure.
     *
     * @param ReadInvitedRequest $request
     *
     * @return JsonResponse
     */
    public function handle(ReadInvitedRequest $request): JsonResponse
    {
        $option = $request->validated();
        return new JsonResponse(
            data: new InvitedResource($this->operation->findById($option['id'])),
            status: 201
        );
    }
}
