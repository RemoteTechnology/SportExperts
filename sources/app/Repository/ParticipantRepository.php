<?php

namespace App\Repository;

use App\Domain\Interfaces\Repositories\LCRUD_OperationInterface;
use App\Models\Participant;
use App\Repository\Traits\CreateQueryTrait;
use App\Repository\Traits\DestroyQueryTrait;
use App\Repository\Traits\ListQueryTrait;
use App\Repository\Traits\ReadQueryTrait;
use App\Repository\Traits\UpdateQueryTrait;
use Illuminate\Database\Eloquent\Model;

final class ParticipantRepository implements LCRUD_OperationInterface
{
    use ListQueryTrait;
    use CreateQueryTrait;
    use ReadQueryTrait;
    use UpdateQueryTrait;
    use DestroyQueryTrait;

    protected Model $model;
    public function __construct(Participant $model = new Participant())
    {
        $this->model = $model;
    }
}
