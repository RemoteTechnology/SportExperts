<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Inviteds;

use App\Domain\Abstracts\AbstractProcedure;
use App\Http\Requests\Inviteds\InvitedListRequest;
use App\Http\Resources\Inviteds\InvitedCollection;
use App\Models\Invite;
use App\Repository\InvitedRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

require_once dirname(__DIR__, 4) . '/Domain/Constants/EntitiesConst.php';
require_once dirname(__DIR__, 4) . '/Domain/Constants/FieldConst.php';
require_once dirname(__DIR__, 4) . '/Domain/Constants/ProcedureNameConst.php';

class InvitedListProcedure extends AbstractProcedure
{
    public static string $name = PROCEDURE_INVITE_LIST;

    private InvitedRepository $invitesRepository;

    public function __construct(InvitedRepository $invitesRepository) {
        $this->invitesRepository = $invitesRepository;
    }

    /**
     * @param InvitedListRequest $request
     * @return JsonResponse
     */
    public function handle(InvitedListRequest $request): JsonResponse
    {
        define('ATTRIBUTES', $request->validated());
        $repository = Invite::where([FIELD_WHO_USER_ID => (int)ATTRIBUTES[FIELD_WHO_USER_ID]])->get();
        $collectData = new InvitedCollection($repository);

        return new JsonResponse(
            data: [
                FIELD_ID => self::identifier(),
                FIELD_ATTRIBUTES => $collectData->resource,
                ...self::meta($request, ATTRIBUTES)
            ],
            status: Response::HTTP_CREATED
        );
    }
}
