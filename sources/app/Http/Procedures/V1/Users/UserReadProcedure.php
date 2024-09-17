<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Users;

use App\Domain\Abstracts\AbstractProcedure;
use App\Http\Requests\Users\ReadUserRequest;
use App\Http\Resources\Users\UserResource;
use App\Repository\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserReadProcedure extends AbstractProcedure
{
    public static string $name = PROCEDURE_USER_READ;
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param ReadUserRequest $request
     * @return JsonResponse
     */
    public function handle(ReadUserRequest $request): JsonResponse
    {
        define('ATTRIBUTES', $request->validated());
        $repository = $this->userRepository->findById((int)ATTRIBUTES[FIELD_ID]);

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
