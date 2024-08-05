<?php

namespace App\Domain\Interfaces\Services\Auth;

use App\Exceptions\Auth\AuthenticationException;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

interface AuthorizationServiceInterface
{
    /**
     * @param User $user
     * @return string
     */
    public function generateBearerToken(User $user): string;

    /**
     * @param array $attributes
     * @return array|AuthenticationException
     */
    public function authorization(array $attributes): array|AuthenticationException;
}
