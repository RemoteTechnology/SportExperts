<?php

namespace App\Domain\Interfaces\Services\Auth;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

interface LogoutServiceInterface
{
    /**
     * @param User $user
     * @return void
     */
    public static function deleteBearerToken(User $user): void;

    /**
     * @param mixed $userContext
     * @return Model
     */
    public function logout(mixed $userContext): Model;
}
