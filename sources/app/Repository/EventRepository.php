<?php

namespace App\Repository;

use App\Domain\Interfaces\Repositories\Entities\EventStatusRepositoryInterface;
use App\Domain\Interfaces\Repositories\LCRUD_OperationInterface;
use App\Models\Event;
use App\Repository\Traits\CreateQueryTrait;
use App\Repository\Traits\DestroyQueryTrait;
use App\Repository\Traits\ListQueryTrait;
use App\Repository\Traits\ReadQueryTrait;
use App\Repository\Traits\StatusQueryTrait;
use App\Repository\Traits\UpdateQueryTrait;
use Illuminate\Database\Eloquent\Model;

final class EventRepository implements
    LCRUD_OperationInterface,
    EventStatusRepositoryInterface
{
    use ListQueryTrait;
    use CreateQueryTrait;
    use ReadQueryTrait;
    use UpdateQueryTrait;
    use DestroyQueryTrait;
    use StatusQueryTrait;

    protected Model $model;
    public function __construct(Event $model = new Event())
    {
        $this->model = $model;
    }
}
