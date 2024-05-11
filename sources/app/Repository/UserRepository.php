<?php

namespace App\Repository;

use App\Domain\Interfaces\Repositories\LCRUD_OperationInterface;
use App\Models\User;
use App\Repository\Traits\CreateQueryTrait;
use App\Repository\Traits\DestroyQueryTrait;
use App\Repository\Traits\ListQueryTrait;
use App\Repository\Traits\ReadQueryTrait;
use App\Repository\Traits\UpdateQueryTrait;
use Illuminate\Database\Eloquent\Model;

class UserRepository implements LCRUD_OperationInterface
{
    use ListQueryTrait, CreateQueryTrait, ReadQueryTrait, UpdateQueryTrait, DestroyQueryTrait;
    protected Model $model;
    public function __construct(User $model = new User())
    {
        $this->model = $model;
    }
}
