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
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

require_once dirname(__DIR__) . '/Domain/Constants/FieldConst.php';

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
     * @return Collection
     */
    public function findByTournamentKey(string $eventKey): Collection
    {
        return $this->model::where([FIELD_EVENT_KEY => $eventKey])->get();
    }

    /**
     * @param Model $entity
     * @param int $stage
     * @return Model
     */
    public function increaseStep(Model $entity, int $stage): Model
    {
        $stage = ++$stage;
        $tournament = Tournament::where([
            FIELD_KEY       => $entity->key,
            FIELD_EVENT_KEY => $entity->event_key,
            FIELD_STAGE     => $stage
        ])->first();
        if (empty($tournament)) {
            $this->model->key = $entity->key;
            $this->model->event_key = $entity->event_key;
            $this->model->stage = $stage;
            $this->model->save();
            return $this->model;
        }
        return $tournament;
    }
}
