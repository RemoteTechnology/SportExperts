<?php

namespace App\Repository;

use App\Domain\Interfaces\Repositories\LCRUD_OperationInterface;
use App\Models\Tournament;
use App\Repository\Traits\CreateQueryTrait;
use App\Repository\Traits\DestroyQueryTrait;
use App\Repository\Traits\GetByKeyTrait;
use App\Repository\Traits\ListQueryTrait;
use App\Repository\Traits\ReadQueryTrait;
use App\Repository\Traits\UpdateQueryTrait;
use Illuminate\Database\Eloquent\Model;

final class TournamentRepository implements LCRUD_OperationInterface
{
    use ListQueryTrait;
    use CreateQueryTrait;
    use ReadQueryTrait;
    use UpdateQueryTrait;
    use DestroyQueryTrait;
    use GetByKeyTrait;

    protected Model $model;
    public function __construct(Tournament $model = new Tournament())
    {
        $this->model = $model;
    }

    /**
     * @param string $eventKey
     * @return Model
     */
    public function findByTournamentKey(string $eventKey): Model
    {
        return $this->model::where(['event_key' => $eventKey])->first();
    }
}
