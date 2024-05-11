<?php

namespace App\Repository\Filter\Entities\Users;

use App\Domain\Abstracts\Repositories\AbstractEloquentRepository;
use App\Domain\Interfaces\Repositories\Filters\Users\FindByEmailRepositoryInterface;
use App\Models\User;
use App\Repository\Traits\Filter\FindByEmailTrait;
use Illuminate\Database\Eloquent\Model;

class FindByEmailRepository extends AbstractEloquentRepository implements FindByEmailRepositoryInterface
{
    use FindByEmailTrait;
    protected function eloquentQuery(): Model
    {
        return new User();
    }
}
