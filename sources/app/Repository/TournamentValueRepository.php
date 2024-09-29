<?php

namespace App\Repository;

use App\Domain\Interfaces\Repositories\LCRUD_OperationInterface;
use App\Models\Event;
use App\Models\Participant;
use App\Models\Tournament;
use App\Models\TournamentValue;
use App\Repository\Traits\CreateQueryTrait;
use App\Repository\Traits\DestroyQueryTrait;
use App\Repository\Traits\ListQueryTrait;
use App\Repository\Traits\ReadQueryTrait;
use App\Repository\Traits\UpdateQueryTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

require_once dirname(__DIR__, ) . '/Domain/Constants/EntitiesConst.php';
require_once dirname(__DIR__, ) . '/Domain/Constants/FieldConst.php';

final class TournamentValueRepository implements LCRUD_OperationInterface
{
    use ListQueryTrait;
    use CreateQueryTrait;
    use ReadQueryTrait;
    use UpdateQueryTrait;
    use DestroyQueryTrait;

    protected Model $model;

    public function __construct(TournamentValue $model = new TournamentValue())
    {
        $this->model = $model;
    }

    /**
     * @param int $tournamentId
     * @return Collection
     */
    public function findByTournamentValue(int $tournaments): Collection
    {

        return $this->model::where([FIELD_TOURNAMENT_ID => $tournaments])->get();
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function queryExists(array $attributes): mixed
    {
        return $this->model::where($attributes)->first();
    }

    private function searchParticipant(array $attributes, Model $event)
    {
        $tournament = Tournament::where([FIELD_EVENT_KEY => $event->key])->first();
        $participant = Participant::where([
            FIELD_USER_ID   => $attributes[FIELD_USER_ID],
            FIELD_EVENT_ID  => $event->id
        ])->first();
        return $this->model::where([
            FIELD_TOURNAMENT_ID     => $tournament->id,
            FIELD_PARTICIPANTS_A    => $participant->key,
        ])->orWhere([
            FIELD_TOURNAMENT_ID     => $tournament->id,
            FIELD_PARTICIPANTS_B    => $participant->key,
        ])->latest(FIELD_ID)
            ->get()
            ->map(function($item) use ($participant) {
                $item->participants_key = $participant->key;
                return $item;
            })
            ->first();
    }

    public function removeParticipant(Model $event, array $attributes)
    {
        $tournamentValues = $this->searchParticipant($attributes, $event);
        // Если у "participants_A" есть соперник, меняем "participants_A" на значение из "participants_B"
        // саму колонку "participants_B" затирем
        if (
            $tournamentValues->recorded_in === FIELD_PARTICIPANTS_A &&
            !is_null($tournamentValues->participants_A) &&
            !is_null($tournamentValues->participants_B)
        )
        {
            $tournamentValues->participants_A = $tournamentValues->participants_B;
            $tournamentValues->participants_B = null;
            $tournamentValues->save();
        }
        // Если у "participants_A" нет соперника, удаляем запись из таблицы
        elseif (
            $tournamentValues->recorded_in === FIELD_PARTICIPANTS_A &&
            !is_null($tournamentValues->participants_A) &&
            is_null($tournamentValues->participants_B)
        )
        {
            $tournamentValueQuery = $tournamentValues;
            $tournamentValueQuery->delete();
        }
        // Если принимаем "participants_B" то тупо его убираем
        elseif ($tournamentValues->recorded_in === FIELD_PARTICIPANTS_B)
        {
            $tournamentValues->participants_B = null;
            $tournamentValues->save();
        }
        return $tournamentValues;
    }

    /**
     * @param Model $event
     * @param array $attributes
     * @return Model
     */
    public function replaceParticipant(Model $event, array $attributes): Model
    {
        $tournament = Tournament::where([FIELD_EVENT_KEY => $event->key])->first();
        $event = Event::where([FIELD_KEY => $attributes[FIELD_EVENT_KEY]])->first();
        $participant = Participant::where([
            FIELD_USER_ID => $attributes[FIELD_USER_ID],
            FIELD_EVENT_ID => $event->id
        ])->first();

        $tournamentValues = TournamentValue::where([
            FIELD_TOURNAMENT_ID => $tournament->id,
            FIELD_PARTICIPANTS_A => $participant->key
        ])->orWhere([
            FIELD_TOURNAMENT_ID => $tournament->id,
            FIELD_PARTICIPANTS_A => $participant->key
        ])->first();

        if ($tournamentValues->participants_A === $participant->key) $tournamentValues->participants_A = $attributes['new_participant_key'];
        if ($tournamentValues->participants_B === $participant->key) $tournamentValues->participants_B = $attributes['new_participant_key'];
        $tournamentValues->save();
        return $tournamentValues;
    }

    /**
     * @param Model $event
     * @param $attributes
     * @return mixed
     */
    public function advanceSkipValue(Model $event, $attributes): mixed
    {
        $tournament = Tournament::where([FIELD_EVENT_KEY => $event->key])->first();
        $tournamentValues = $this->searchParticipant($attributes, $event);
        $value = DB::table(TABLE_TOURNAMENT_VALUES)
            ->where([
            FIELD_TOURNAMENT_ID                 => $tournament->id,
            $tournamentValues->recorded_in  => $tournamentValues[$tournamentValues->recorded_in]
        ]);
        $value->update([
            FIELD_PARTICIPANTS_PASSES => $tournamentValues[$tournamentValues->recorded_in]
        ]);
        return $value->first();
    }

    /**
     * @param Model $event
     * @param array $attributes
     * @return mixed
     */
    public function freeParticipants(Model $event, array $attributes)
    {
        $tableParticipants = TABLE_PARTICIPANTS;
        $tableTournamentValues = TABLE_TOURNAMENT_VALUES;
        $participantsA = FIELD_PARTICIPANTS_A;
        $participantsB = FIELD_PARTICIPANTS_B;
        $tournament = Tournament::where(['event_key' => $event->key])->first();
        return DB::select(/** @lang text */ "
            SELECT * FROM {$tableParticipants} AS p
            INNER JOIN {$tableTournamentValues} AS tv
                    ON p.key = tv.\"{$participantsA}\"
            WHERE tv.tournament_id = {$tournament->id} AND
                  tv.\"{$participantsB}\" IS NULL;
        ");
    }
}
