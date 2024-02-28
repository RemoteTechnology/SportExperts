<?php

namespace App\Services\Contracts;

use App\Models\User;

interface UserServiceInterface
{
    public function create(array $context): User;
    public function auth(User $user): string;
    public function authSocial(array $context): User;
    public function logout(User $user);
    public function showById(array $user): User;
    public function showByEmail(array $user): User;
}
