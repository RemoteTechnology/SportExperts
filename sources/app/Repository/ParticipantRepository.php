<?php

namespace App\Repository;

use App\Domain\Interfaces\Repositories\LCRUD_OperationInterface;
use App\Models\Participant;
use App\Repository\Filter\Entities\Participants\ParticipantIsUserFilter;
use App\Repository\Traits\CreateQueryTrait;
use App\Repository\Traits\DestroyQueryTrait;
use App\Repository\Traits\GetByKeyTrait;
use App\Repository\Traits\ListQueryTrait;
use App\Repository\Traits\ReadQueryTrait;
use App\Repository\Traits\UpdateQueryTrait;
use Illuminate\Database\Eloquent\Model;

final class ParticipantRepository extends ParticipantIsUserFilter implements LCRUD_OperationInterface
{
    use ListQueryTrait;
    use CreateQueryTrait;
    use ReadQueryTrait;
    use UpdateQueryTrait;
    use DestroyQueryTrait;
    use GetByKeyTrait;

    protected Model $model;
    public function __construct(Participant $model = new Participant())
    {
        $this->model = $model;
    }

    public function findByEventId(int $event_id)
    {
        return $this->model->where(['event_id' => $event_id])->get();
    }
}
