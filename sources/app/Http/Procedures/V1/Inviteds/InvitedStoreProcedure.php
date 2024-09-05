<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Inviteds;

use App\Domain\Constants\EnumConstants\ResponseTypeEnum;
use App\Http\Requests\Inviteds\InviteStoreRequest;
use App\Http\Resources\Inviteds\InvitedResource;
use App\Repository\InvitedRepository;
use Illuminate\Http\JsonResponse;
use Sajya\Server\Procedure;
use TypeError;

require_once dirname(__DIR__, 4) . '/Domain/Constants/InviteMessageConst.php';

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
        try {
            $this->invitedRepository->filter($invite['user_id']);
            // TODO: По завершению разработки жеребьёвки, перед реализацией турнирной таблицы сделать так все респонсы.
            // TODO: Если такой пользователь есть в системе отправить письмо на почту с восстановлением пароля! Возможно это взлом!
            return  new JsonResponse(
                data: [
                    "request" => $request->toArray(),
                    "response_type" => ResponseTypeEnum::MessageErrorResponse,
                    "response" => ALREADY_PRESENT
                ],
                status: 201
            );
        }
        catch (TypeError)
        {
            return  new JsonResponse(
                data: [
                    "request" => $request->toArray(),
                    "response_type" => ResponseTypeEnum::DataResponse,
                    "response" => new InvitedResource(
                        $this->invitedRepository->store($invite)
                    )
                ],
                status: 201
            );
        }
    }
}
