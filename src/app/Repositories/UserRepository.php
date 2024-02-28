<?php

namespace App\Repositories;

use App\Models\User;

final class UserRepository
{
    public function create(array $user): User|array
    {
        return User::create($user);
    }
    public function show(array $user)
    {
        if (key_exists('email', $user))
        {
            return User::where('email', '=', $user['email'])
                ->latest()
                ->first();
        }
        return User::find($user['id']);
    }

}
