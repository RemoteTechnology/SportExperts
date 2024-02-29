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
use Illuminate\Support\Facades\Hash;
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
            )
        )->setStatusCode(201);
    }

    final public function auth(AuthorizationUserRequest $request)
    {
        $request->validated();
        $user = $this->userService->showByEmail($request->toArray());

        if (Hash::check($request['password'], $user['password']))
        {
            return response()->json([
                'user' => new UserResource($user),
                'personal_access_token' => $this->userService->auth($user)
            ])->setStatusCode(201);
        }
        return response()->json($user)->setStatusCode(201);
    }

//    final public function authSocialCallback(Request $request)
//    {
//        return Socialite::driver('vkontakte')->redirect();
//    }

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
    final public function show(ShowByIdRequest|ShowByEmailRequest|array $request)
    {
        try{
            $request->validated();
        }
        catch (\Error $e) {}
        if (key_exists('id', $request))
        {
            return response()->json(
                new UserResource(
                    $this->userService->showById($request)
                )
            );
        }
        if (key_exists('email', $request))
        {
            return response()->json(
                new UserResource(
                    $this->userService->showByEmail($request)
                )
            );
        }
    }
}
