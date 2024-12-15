<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Users;

use App\Domain\Abstracts\AbstractProcedure;
use App\Domain\Constants\EnumConstants\ClientRoleNameEnum;
use App\Domain\Constants\EnumConstants\RoleEnum;
use App\Http\Requests\Users\RegistrationUserRequest;
use App\Http\Resources\Users\UserResource;
use App\Jobs\MailJob;
use App\Mail\Users\RegistrationUserMail;
use App\Repository\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

require_once dirname(__DIR__, 4) . '/Domain/Constants/ProcedureNameConst.php';
require_once dirname(__DIR__, 4) . '/Domain/Constants/FieldConst.php';

class UserRegistrationProcedure extends AbstractProcedure
{
    public static string $name = PROCEDURE_USER_REGISTRATION;
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param RegistrationUserRequest $request
     * @return JsonResponse
     */
    public function handle(RegistrationUserRequest $request): JsonResponse
    {
        $attributes = $request->validated();
        $attributes[FIELD_PASSWORD] = Hash::make($attributes[FIELD_PASSWORD]);
        $repository = $this->userRepository->store($attributes);
        unset($attributes[FIELD_PASSWORD]);

        MailJob::dispatch(RegistrationUserMail::class, $attributes);

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
