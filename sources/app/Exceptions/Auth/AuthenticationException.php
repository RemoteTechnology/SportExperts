<?php

namespace App\Exceptions\Auth;

use Exception;

class AuthenticationException extends Exception
{
    protected $message = 'Ошибка! Невозможно определить пользователя в системе.';
}
