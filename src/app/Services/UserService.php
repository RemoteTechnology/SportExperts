<?php

namespace App\Services;

use App\Http\Requests\Users\AuthorizationUserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    private UserRepository $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create(array $context): User
    {
        $context['password'] = Hash::make($context['password']);
        return $this->userRepository->create($context);
    }

    public function auth(User $user): string
    {
        return User::createBearerTocken($user);
    }

    public function authSocial(array $context): User
    {
        try {
            return $this->auth($context);
        }
        catch (\Exception $e)
        {
            return $this->auth((array)$this->create($context));
        }
    }

    public function logout(User $user)
    {
        return User::deleteBearerTocken($user);
    }

    public function showById(array|User $context): User
    {
        return $this->userRepository->show($context);
    }

    public function showByEmail(array|User $context)
    {
        return $this->userRepository->show($context);
    }
}
