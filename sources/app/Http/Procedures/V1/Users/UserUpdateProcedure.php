<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Users;

use App\Domain\Abstracts\AbstractProcedure;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Http\Resources\Users\UserResource;
use App\Repository\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

require_once dirname(__DIR__, 4) . '/Domain/Constants/ProcedureNameConst.php';
require_once dirname(__DIR__, 4) . '/Domain/Constants/FieldConst.php';

class UserUpdateProcedure extends AbstractProcedure
{
    public static string $name = PROCEDURE_USER_UPDATE;
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param UpdateUserRequest $request
     * @return JsonResponse
     */
    public function handle(UpdateUserRequest $request): JsonResponse
    {
        define('ATTRIBUTES', $request->validated());
        $user = $this->userRepository->findById((int)ATTRIBUTES[FIELD_ID]);
        $repository = $this->userRepository->update($user, ATTRIBUTES);

        return new JsonResponse(
            data: [
                FIELD_ID => self::identifier(),
                FIELD_ATTRIBUTES => new UserResource($repository),
                ...self::meta($request, ATTRIBUTES)
            ],
            status: Response::HTTP_CREATED
        );
    }
}
