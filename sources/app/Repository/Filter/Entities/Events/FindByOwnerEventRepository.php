<?php

namespace App\Repository\Filter\Entities\Events;

use App\Domain\Abstracts\Repositories\AbstractEloquentRepository;
use App\Domain\Interfaces\Repositories\FilterRepositoryInterface;
use App\Models\Event;
use App\Repository\Traits\FilterTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class FindByOwnerEventRepository extends AbstractEloquentRepository implements FilterRepositoryInterface
{
    use FilterTrait;
    protected function eloquentQuery(): Model
    {
        return new Event();
    }
}
