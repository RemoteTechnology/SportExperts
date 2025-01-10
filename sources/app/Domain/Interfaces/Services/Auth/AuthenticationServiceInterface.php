<?php

namespace App\Domain\Interfaces\Services\Auth;

use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of Model
 */
interface AuthenticationServiceInterface
{
    /**
     * @param array $attributes
     * @return Model|null
     */
    public function identification(array $attributes): Model|null;
}
