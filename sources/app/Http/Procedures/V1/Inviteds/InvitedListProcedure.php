<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Inviteds;

use App\Http\Requests\Inviteds\InvitedListRequest;
use App\Http\Resources\Inviteds\InvitedCollection;
use App\Models\Invite;
use App\Repository\InvitedRepository;
use App\Repository\OptionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Sajya\Server\Procedure;

require_once dirname(__DIR__, 4) . '/Domain/Constants/EntitiesConst.php';
require_once dirname(__DIR__, 4) . '/Domain/Constants/FieldConst.php';

class InvitedListProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'InvitedListProcedure';

    private InvitedRepository $invitesRepository;

    public function __construct(InvitedRepository $invitesRepository) {
        $this->invitesRepository = $invitesRepository;
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
        $attributes = $request->validated();
        $invites = Invite::where([FIELD_WHO_USER_ID => (int)$attributes[FIELD_WHO_USER_ID]])->get();
        $collectData = new InvitedCollection($invites);
        return new JsonResponse(
            data: $collectData->resource,
            status: Response::HTTP_CREATED
        );
    }
}
