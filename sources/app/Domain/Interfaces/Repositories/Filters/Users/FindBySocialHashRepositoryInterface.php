<?php

namespace App\Domain\Interfaces\Repositories\Filters\Users;

use App\Domain\Abstracts\Repositories\AbstractEloquentRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * @template T of Model
 */
interface FindBySocialHashRepositoryInterface
{
    public function findBySocialHash(string $hash): AbstractEloquentRepository;
}
