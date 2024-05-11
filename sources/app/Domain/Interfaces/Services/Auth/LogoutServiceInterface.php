<?php

namespace App\Domain\Interfaces\Services\Auth;

use App\Models\User;

interface LogoutServiceInterface
{
    /**
     * @param User $user
     * @return void
     */
    public static function deleteBearerToken(User $user): void;

    /**
     * @return void
     */
    public function logout(): void;
}
