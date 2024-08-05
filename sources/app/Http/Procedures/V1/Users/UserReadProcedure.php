<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Users;

use App\Http\Requests\Users\ReadUserRequest;
use App\Http\Resources\Users\UserResource;
use App\Repository\UserRepository;
use Illuminate\Http\JsonResponse;
use Sajya\Server\Procedure;

class UserReadProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'UserReadProcedure';
    private UserRepository $operation;

    /**
     * @param UserRepository $operation
     */
    public function __construct(UserRepository $operation)
    {
        $this->operation = $operation;
    }

    /**
     * Execute the procedure.
     *
     * @param ReadUserRequest $request
     *
     * @return JsonResponse
     */
    public function handle(ReadUserRequest $request): JsonResponse
    {
        $user = $request->validated();
        return new JsonResponse(
            data: $this->operation->findById((int)$user['id']),
            status: 201
        );
    }
}
