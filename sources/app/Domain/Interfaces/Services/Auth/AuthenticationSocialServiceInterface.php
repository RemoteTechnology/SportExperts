<?php

namespace App\Domain\Interfaces\Services\Auth;


use App\Exceptions\Auth\AuthenticationException;

interface AuthenticationSocialServiceInterface
{
    /**
     * @param array $attributes
     * @return AuthenticationException|array
     */
    public function createOrAuthSocial(array $attributes): AuthenticationException|array;
}
