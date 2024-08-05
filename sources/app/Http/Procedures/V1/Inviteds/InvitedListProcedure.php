<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Inviteds;

use App\Http\Requests\Inviteds\InvitedListRequest;
use App\Http\Resources\Inviteds\InvitedCollection;
use App\Repository\InvitedRepository;
use App\Repository\OptionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Sajya\Server\Procedure;

class InvitedListProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'InvitedListProcedure';

    private InvitedRepository $operation;

    public function __construct(InvitedRepository $operation) {
        $this->operation = $operation;
    }

    /**
     * Execute the procedure.
     *
     * @param InvitedListRequest $request
     *
     * @return JsonResponse
     */
    public function handle(InvitedListRequest $request): JsonResponse
    {
//        $invites = new InvitedCollection($this->operation->list('paginate')->where(['who_user_id' => $request->validated()['who_user_id']]));
        $invites = $request->validated();
        $invitesList = new InvitedCollection(
            DB::table('inviteds')
                ->select('*')
                ->where(['user_id' => (int)$invites['who_user_id']])
                ->paginate(12)
        );
        return new JsonResponse(
            data: $invitesList->collection,
            status: 201
        );
    }
}
