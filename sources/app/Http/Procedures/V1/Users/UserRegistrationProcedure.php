<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Users;

use App\Domain\Abstracts\AbstractProcedure;
use App\Domain\Constants\EnumConstants\RoleEnum;
use App\Http\Requests\Users\RegistrationUserRequest;
use App\Http\Resources\Users\UserResource;
use App\Repository\UserRepository;
use App\Services\MailingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

require_once dirname(__DIR__, 4) . '/Domain/Constants/ProcedureNameConst.php';
require_once dirname(__DIR__, 4) . '/Domain/Constants/FieldConst.php';

class UserRegistrationProcedure extends AbstractProcedure
{
    public static string $name = PROCEDURE_USER_REGISTRATION;
    private UserRepository $userRepository;
    private MailingService $mailingService;

    public function __construct(UserRepository $userRepository, MailingService $mailingService)
    {
        $this->userRepository = $userRepository;
        $this->mailingService = $mailingService;
    }

    /**
     * @param RegistrationUserRequest $request
     * @return JsonResponse
     */
    public function handle(RegistrationUserRequest $request): JsonResponse
    {
        $attributes = $request->validated();
        $attributes[FIELD_PASSWORD] = Hash::make($attributes[FIELD_PASSWORD]);
        $attributes[FIELD_ROLE] = key_exists(FIELD_ROLE, $attributes) ? $attributes[FIELD_ROLE] : RoleEnum::ATHLETE;
        $repository = $this->userRepository->store($attributes);
        $this->mailingService->mailNewUser([FIELD_EMAIL => $attributes[FIELD_EMAIL]]);
        unset($attributes[FIELD_PASSWORD]);

        return new JsonResponse(
             data: [
                 FIELD_ID => self::identifier(),
                 FIELD_ATTRIBUTES => new UserResource($repository),
                 ...self::meta($request, $attributes)
            ],
            status: Response::HTTP_CREATED
        );
    }
}
