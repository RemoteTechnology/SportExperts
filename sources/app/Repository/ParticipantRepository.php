<?php

namespace App\Repository;

use App\Domain\Interfaces\Repositories\LCRUD_OperationInterface;
use App\Models\Event;
use App\Models\Participant;
use App\Repository\Filter\Entities\Participants\ParticipantIsUserFilter;
use App\Repository\Traits\CreateQueryTrait;
use App\Repository\Traits\DestroyQueryTrait;
use App\Repository\Traits\GetByKeyTrait;
use App\Repository\Traits\ListQueryTrait;
use App\Repository\Traits\ReadQueryTrait;
use App\Repository\Traits\UpdateQueryTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function findByEventId(int $eventId)
    {
        return $this->model->where(['event_id' => $eventId])->get();
    }

    /**
     * @param string $eventKey
     * @return array
     */
    public function findByEventKey(string $eventKey): array
    {
        return DB::select(/** @lang text */ "
            SELECT p.* FROM participants AS p
            LEFT JOIN events AS e
            ON p.event_id = e.id
            WHERE e.key = '{$eventKey}';
        ");
    }

    public function removeUser(Model $event, array $attributes)
    {
        $data['key'] = array_key_exists('participants_A', $attributes)
            ? $attributes['participants_A'] : $attributes['participants_B'];
        return $this->model::where(['event_id' => $event->id, ...$data])->delete();
    }
}
