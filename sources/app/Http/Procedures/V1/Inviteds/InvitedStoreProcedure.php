<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Inviteds;

use App\Domain\Abstracts\AbstractProcedure;
use App\Domain\Constants\EnumConstants\ResponseTypeEnum;
use App\Http\Requests\Inviteds\InviteStoreRequest;
use App\Http\Resources\Inviteds\InvitedResource;
use App\Repository\InvitedRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use TypeError;

require_once dirname(__DIR__, 4) . '/Domain/Constants/InviteMessageConst.php';
require_once dirname(__DIR__, 4) . '/Domain/Constants/ProcedureNameConst.php';
require_once dirname(__DIR__, 4) . '/Domain/Constants/FieldConst.php';

class InvitedStoreProcedure extends AbstractProcedure
{
    public static string $name = PROCEDURE_INVITE_STORE;
    private InvitedRepository $invitedRepository;

    public function __construct(InvitedRepository $invitedRepository)
    {
        $this->invitedRepository = $invitedRepository;
    }

    /**
     * @param InviteStoreRequest $request
     * @return JsonResponse
     */
    public function handle(InviteStoreRequest $request): JsonResponse
    {
        define('ATTRIBUTES', $request->validated());
        try {
            $this->invitedRepository->filter(ATTRIBUTES[FIELD_USER_ID]);
            return  new JsonResponse(
                data: [
                    FIELD_ATTRIBUTES =>  [
                        FIELD_MESSAGE => ResponseTypeEnum::MessageErrorResponse
                    ],
                    ...self::meta($request, ATTRIBUTES)
                ],
                status: Response::HTTP_CREATED
            );
        }
        catch (TypeError)
        {
            $repository = $this->invitedRepository->store(ATTRIBUTES);
            return  new JsonResponse(
                data: [
                    FIELD_ID => self::identifier(),
                    FIELD_ATTRIBUTES => new InvitedResource($repository),
                    ...self::meta($request, ATTRIBUTES)
                ],
                status: Response::HTTP_CREATED
            );
        }
    }
}
