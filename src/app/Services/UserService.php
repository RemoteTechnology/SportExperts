<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Support\Facades\Auth;

class UserService
{
    private UserRepository $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create(array $context): User
    {
        return $this->userRepository->create($context);
    }

    public function auth(array $context): User
    {
        return Auth::login($this->userRepository->show($context));
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

    public function logout(User $user): void
    {
        Auth::logout();
    }

    public function showById(array|User $context): User
    {
        return $this->userRepository->show($context);
    }

    public function showByEmail(array|User $context): User
    {
        return $this->userRepository->show($context);
    }
}
