<?php

namespace App\Repository;

use App\Domain\Constants\EnumConstants\RoleEnum;
use App\Domain\Interfaces\Repositories\LCRUD_OperationInterface;
use App\Models\User;
use App\Repository\Traits\CreateQueryTrait;
use App\Repository\Traits\DestroyQueryTrait;
use App\Repository\Traits\ListQueryTrait;
use App\Repository\Traits\ReadQueryTrait;
use App\Repository\Traits\UpdateQueryTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

final class UserRepository implements LCRUD_OperationInterface
{
    use ListQueryTrait;
    use CreateQueryTrait;
    use ReadQueryTrait;
    use UpdateQueryTrait;
    use DestroyQueryTrait;

    protected Model $model;
    public function __construct(User $model = new User())
    {
        $this->model = $model;
    }

    /**
     * @param array $role
     * @return Collection
     */
    public function findByRole(array $role): Collection
    {
        return $this->model::where('role', $role[0])->orWhere('role', $role[1])->get();
    }
}
