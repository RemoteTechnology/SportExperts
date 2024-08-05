<?php

namespace App\Repository\Filter\Entities\Users;

use App\Domain\Abstracts\Repositories\AbstractEloquentRepository;
use App\Domain\Interfaces\Repositories\FilterRepositoryInterface;
use App\Models\User;
use App\Repository\Traits\FilterTrait;
use Illuminate\Database\Eloquent\Model;

class FindByEmailRepository extends AbstractEloquentRepository implements FilterRepositoryInterface
{
    use FilterTrait;
    protected function eloquentQuery(): Model
    {
        return new User();
    }
}
