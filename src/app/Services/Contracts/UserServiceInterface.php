<?php

namespace App\Services\Contracts;

use App\Models\User;

interface UserServiceInterface
{
    public function create(array $context): User;
    public function auth(array $context): User;
    public function authSocial(array $context): User;
    public function logout(User $user): void;
    public function showById(array $user): User;
    public function showByEmail(array $user): User;
}
