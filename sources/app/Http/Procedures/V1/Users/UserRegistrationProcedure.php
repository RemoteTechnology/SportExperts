<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Users;

use App\Domain\Constants\LogLevelEnum;
use App\Http\Requests\Users\RegistrationUserRequest;
use App\Http\Resources\Users\UserResource;
use App\Repository\UserRepository;
use App\Services\LoggingService;
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
//    private LoggingService $loggingService;

    /**
     * @param UserRepository $operation
     */
    public function __construct(UserRepository $operation)//, LoggingService $loggingService)
    {
        $this->operation = $operation;
//        $this->loggingService = $loggingService;
    }

    /**
     * @param Request $http
     * @param RegistrationUserRequest $request
     * @return JsonResponse
     */
    public function handle(Request $http, RegistrationUserRequest $request): JsonResponse
    {
        $inputData = $request->validated();
        $inputData['password'] = Hash::make($inputData['password']);
        $inputData['role'] = 'admin';
//        try {
            return new JsonResponse(
                new UserResource(
                    $this->operation->store($inputData)
                )
            );
//        }
//        catch (Exception $e)
//        {
//            $this->loggingService->write(LogLevelEnum::Error, [
//                'action'        => self::$name,
//                'description'   => $e->getMessage(),
//                'input_data'    => $inputData,
//                'slug'          => $http->url(),
//            ]);
//            return new JsonResponse();
//        }
    }
}
