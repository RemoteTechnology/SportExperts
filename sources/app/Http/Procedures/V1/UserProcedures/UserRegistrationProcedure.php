<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\UserProcedures;

use App\Domain\Interfaces\Repositories\LCRUD_OperationInterface;
use App\Http\Requests\Users\RegistrationUserRequest;
use App\Http\Resources\Users\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Sajya\Server\Procedure;

class UserRegistrationProcedure extends Procedure
{
    public static string $name = 'UserRegistrationProcedure';
    private LCRUD_OperationInterface $operation;

    public function __construct(LCRUD_OperationInterface $operation) {
        $this->operation = $operation;
    }

    /**
     * @param RegistrationUserRequest $request
     * @return JsonResponse
     */
    public function handle(RegistrationUserRequest $request): JsonResponse
    {
        $inputData = $request->validated();
        $inputData['password'] = Hash::make($inputData['password']);
        return new JsonResponse(
            new UserResource(
                $this->operation->store($inputData)
            )
        );
    }
}
