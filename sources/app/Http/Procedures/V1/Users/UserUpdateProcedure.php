<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Users;

use App\Http\Requests\Users\UpdateUserRequest;
use App\Http\Resources\Users\UserResource;
use App\Repository\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Sajya\Server\Procedure;

class UserUpdateProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'UserUpdateProcedure';
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Execute the procedure.
     *
     * @param UpdateUserRequest $request
     *
     * @return JsonResponse
     */
    public function handle(UpdateUserRequest $request): JsonResponse
    {
        $user = $request->validated();
        return new JsonResponse(
            data: new UserResource(
                $this->repository->update(
                    $this->repository->findById((int)$user['id']),
                    $user
                )
            ),
            status: 201
        );
    }
}
