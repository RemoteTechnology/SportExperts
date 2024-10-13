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
use Illuminate\Http\JsonResponse;
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
        //$tournamentValues = $this->searchParticipant($attributes, $event);
        $tournament = Tournament::where([
            FIELD_EVENT_KEY => $event->key,
            FIELD_STAGE => $attributes[FIELD_STAGE]
        ])->first();
        $participant = Participant::where([
            FIELD_USER_ID   => $attributes[FIELD_USER_ID],
            FIELD_EVENT_ID  => $event->id
        ])->first();
        $tournamentValues = $this->model::where([
            FIELD_TOURNAMENT_ID => $tournament->id,
            $attributes[FIELD_PARTICIPANTS_POSITION] => $participant->key
        ])->first();
        // Если у "participants_A" есть соперник, меняем "participants_A" на значение из "participants_B"
        // саму колонку "participants_B" затирем
        if (
            $attributes[FIELD_PARTICIPANTS_POSITION] === FIELD_PARTICIPANTS_A &&
            !is_null($tournamentValues->participants_A) &&
            !is_null($tournamentValues->participants_B)
        )
        {
            DB::table(TABLE_TOURNAMENT_VALUES)
                ->select()
                ->where([
                    FIELD_ID => $tournamentValues->id,

                ])
                ->update([
                    FIELD_PARTICIPANTS_A => $tournamentValues->participants_B,
                    FIELD_PARTICIPANTS_B => null,
                ]);
        }
        // Если у "participants_A" нет соперника, удаляем запись из таблицы
        elseif (
            $attributes[FIELD_PARTICIPANTS_POSITION] === FIELD_PARTICIPANTS_A &&
            !is_null($tournamentValues->participants_A) &&
            is_null($tournamentValues->participants_B)
        )
        {
            $tournamentValueQuery = $tournamentValues;
            $tournamentValueQuery->delete();
        }
        // Если принимаем "participants_B" то тупо его убираем
        elseif ($attributes[FIELD_PARTICIPANTS_POSITION] === FIELD_PARTICIPANTS_B)
        {
            DB::table(TABLE_TOURNAMENT_VALUES)
                ->select()
                ->where([
                    FIELD_ID => $tournamentValues->id
                ])
                ->update([
                    FIELD_PARTICIPANTS_B => null,
                ]);
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
        $tournament = Tournament::where([
            FIELD_EVENT_KEY => $event->key,
            FIELD_STAGE     => $attributes[FIELD_STAGE]
        ])->first();
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
        $participant = DB::table(TABLE_PARTICIPANTS)
            ->where([
                FIELD_EVENT_ID  => $event->id,
                FIELD_USER_ID   => $attributes[FIELD_USER_ID]
            ])->limit(1)->get();
        $value = DB::table(TABLE_TOURNAMENT_VALUES)->where([
            FIELD_ID            => $attributes[FIELD_TOURNAMENT_VALUE_ID],
            FIELD_TOURNAMENT_ID => $tournament->id
        ]);
        $value->update([
            FIELD_PARTICIPANTS_PASSES => $participant[0]->key,
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

    /**
     * @param Model $entity
     * @return void
     */
    public function copyAthlete(Model $entity, array $attributes): void
    {
        $participant = Participant::where([FIELD_USER_ID => $attributes[FIELD_USER_ID]])->first();
        $tournamentValue = TournamentValue::where([
            FIELD_TOURNAMENT_ID => $entity->id,
            FIELD_PARTICIPANTS_A => $participant->key
        ])->orWhere([
            FIELD_TOURNAMENT_ID => $entity->id,
            FIELD_PARTICIPANTS_B => $participant->key
        ])->first();
        //if (empty($tournamentValue)) {
            $this->model->tournament_id = $entity->id;
            $this->model->participants_A = $participant->key;
            $this->model->participants_B = null;
            $this->model->participants_passes = null;
            $this->model->save();
        //}
    }
}
