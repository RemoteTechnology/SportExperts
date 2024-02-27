<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\AuthorizationUserRequest;
use App\Http\Requests\Users\IdentityBySocialRequest;
use App\Http\Requests\Users\RegistrationUserRequest;
use App\Http\Requests\Users\ShowByEmailRequest;
use App\Http\Requests\Users\ShowByIdRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;


class UserController extends Controller
{
    private UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    final public function create(RegistrationUserRequest $request)
    {
        $user = $request->validated();
        $user['is_admin'] = false;
        return response()->json(
            new UserResource(
                $this->userService->create($user)
            ),
            201
        );
    }

    final public function auth(AuthorizationUserRequest $request)
    {
        $this->userService->auth($request->validated());
        // redirect
    }

    final public function authSocialCallback(string $driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    final public function authSocial(Request $request)
    {
        return $request;
        return $this->userService->authSocial($request);
    }

    final public function logout()
    {
        $this->userService->logout(
            $this->userService->showById(Auth::id())
        );
        // redirect
    }
    final public function show(ShowByIdRequest|ShowByEmailRequest $request)
    {
        if ($request::class == 'ShowByIdRequest')
        {
            return response()->json(
                new UserResource(
                    $this->userService->showById($request)
                )
            );
        }
        else
        {
            return response()->json(
                new UserResource(
                    $this->userService->showByEmail($request)
                )
            );
        }

    }
}
