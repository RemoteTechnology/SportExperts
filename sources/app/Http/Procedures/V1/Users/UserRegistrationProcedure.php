<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Users;

use App\Domain\Constants\LogLevelEnum;
use App\Domain\Interfaces\Repositories\Entities\UserRepositoryInterface;
use App\Domain\Interfaces\Repositories\LCRUD_OperationInterface;
use App\Domain\Interfaces\Services\LoggingServiceInterface;
use App\Http\Requests\Users\RegistrationUserRequest;
use App\Http\Resources\UserResource;
use App\Repository\UserRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Sajya\Server\Procedure;

class UserRegistrationProcedure extends Procedure
{
    public static string $name = 'UserRegistrationProcedure';
    /**
     * @var UserRepository
     */
    private UserRepository $operation;
//    private LoggingServiceInterface $loggingService;

    /**
     * @param UserRepository $operation
     */
    public function __construct(UserRepository $operation)//, LoggingServiceInterface $loggingService)
    {
        $this->operation = $operation;
//        $this->loggingService = $loggingService;
    }

    /**
     * @param RegistrationUserRequest $request
     * @return JsonResponse
     */
    public function handle(RegistrationUserRequest $request): JsonResponse
    {
        $inputData = $request->validated();
        $inputData['password'] = Hash::make($inputData['password']);
        $inputData['role'] = 'admin';
        try {
            return new JsonResponse(
                new UserResource(
                    $this->operation->store($inputData)
                )
            );
        }
        catch (Exception $e)
        {
//            $this->loggingService->write(LogLevelEnum::Error, [
//                'action'        => self::$name,
//                'description'   => $e->getMessage(),
//                'input_data'    => $inputData,
//                'slug'          => $http->url(),
//            ]);
            return new JsonResponse();
        }
    }
}
