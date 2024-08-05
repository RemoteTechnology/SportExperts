<?php

namespace App\Domain\Interfaces\Repositories\Filters\Users;

use App\Domain\Interfaces\Repositories\FilterRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * @template T of Model
 */
interface FindByEmailRepositoryInterface extends FilterRepositoryInterface
{
}
