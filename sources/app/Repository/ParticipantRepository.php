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

require_once dirname(__DIR__) . '/Domain/Constants/FieldConst.php';

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

    /**
     * @param int $eventId
     * @return mixed
     */
    public function findByEventId(int $eventId)
    {
        return $this->model->where([FIELD_EVENT_ID => $eventId])->get();
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

    /**
     * @param Model $event
     * @param array $attributes
     * @return bool
     */
    public function removeUser(Model $event, array $attributes): bool
    {
        $data[FIELD_KEY] = array_key_exists(FIELD_PARTICIPANTS_A, $attributes)
            ? $attributes[FIELD_PARTICIPANTS_A] : $attributes[FIELD_PARTICIPANTS_B];
        return $this->model::where([FIELD_EVENT_ID => $event->id, ...$data])->delete();
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function findByKeyIsEvent(array $attributes): Model
    {
        return $this->model::where([
            FIELD_EVENT_ID  => $attributes[FIELD_EVENT_ID],
            FIELD_USER_ID   => $attributes[FIELD_USER_ID],
        ])->first();
    }
}
