<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Users;

use App\Http\Requests\Users\RegistrationUserRequest;
use App\Http\Resources\Users\UserResource;
use App\Repository\UserRepository;
use App\Services\LoggingService;
use App\Services\MailingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Sajya\Server\Procedure;

require_once dirname(__DIR__, 4) . '/Domain/Constants/FieldConst.php';

class UserRegistrationProcedure extends Procedure
{
    public static string $name = 'UserRegistrationProcedure';
    /**
     * @var UserRepository
     */
    private UserRepository $operation;
//    private LoggingService $loggingService;
    private MailingService $mailingService;

    /**
     * @param UserRepository $operation
     */
    public function __construct(UserRepository $operation, MailingService $mailingService)//, LoggingService $loggingService)
    {
        $this->operation = $operation;
//        $this->loggingService = $loggingService;
        $this->mailingService = $mailingService;
    }

    /**
     * @param Request $http
     * @param RegistrationUserRequest $request
     * @return JsonResponse
     */
    public function handle(Request $http, RegistrationUserRequest $request): JsonResponse
    {
        $attributes = $request->validated();
//        try {
        $attributes['password'] = Hash::make($attributes['password']);
        $attributes['role'] = key_exists('role', $attributes) ? $attributes['role'] : 'athlete'; //'admin';

            if ($user = new UserResource(
                $this->operation->store($attributes)
            )) {
                $this->mailingService->mailNewUser([FIELD_EMAIL => $user->email]);
                return new JsonResponse(
                    data: $user,
                    status: 201
                );
            }
//        }
//        catch (Exception $e)
//        {
//            $this->loggingService->write(LogLevelEnum::Error, [
//                'action'        => self::$name,
//                'description'   => $e->getMessage(),
//                'input_data'    => $inputData,
//                'slug'          => $http->url(),
//            ]);
//        }
//        return new JsonResponse();
    }
}
