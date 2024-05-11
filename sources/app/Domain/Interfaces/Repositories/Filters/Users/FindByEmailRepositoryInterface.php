<?php

namespace App\Domain\Interfaces\Repositories\Filters\Users;

use Illuminate\Database\Eloquent\Model;

/**
 * @template T of Model
 */
interface FindByEmailRepositoryInterface
{
    /**
     * @param string $email
     * @return Model
     */
    public function findByEmailQuery(string $email): Model;
}
