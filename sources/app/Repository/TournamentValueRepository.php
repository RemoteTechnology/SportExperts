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
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

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
    public function findByTournamentValue(int $tournamentId): Collection
    {
        return $this->model::where(['tournament_id' => $tournamentId])->get();
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
        $tournament = Tournament::where(['event_key' => $event->key])->first();
        $participant = Participant::where([
            'user_id' => $attributes['user_id'],
            'event_id' => $event->id
        ])->first();
        return $this->model::where([
            'tournament_id'     => $tournament->id,
            'participants_A'    => $participant->key,
        ])->orWhere([
            'tournament_id'     => $tournament->id,
            'participants_B'    => $participant->key,
        ])->latest('id')
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
            $tournamentValues->recorded_in === 'participants_A' &&
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
            $tournamentValues->recorded_in === 'participants_A' &&
            !is_null($tournamentValues->participants_A) &&
            is_null($tournamentValues->participants_B)
        )
        {
            $tournamentValueQuery = $tournamentValues;
            $tournamentValueQuery->delete();
        }
        // Если принимаем "participants_B" то тупо его убираем
        elseif ($tournamentValues->recorded_in === 'participants_B')
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
        $tournament = Tournament::where(['event_key' => $event->key])->first();
        $event = Event::where(['key' => $attributes['event_key']])->first();
        $participant = Participant::where([
            'user_id' => $attributes['user_id'],
            'event_id' => $event->id
        ])->first();

        $tournamentValues = TournamentValue::where([
            'tournament_id' => $tournament->id,
            'participants_A' => $participant->key
        ])->orWhere([
            'tournament_id' => $tournament->id,
            'participants_B' => $participant->key
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
        $tournament = Tournament::where(['event_key' => $event->key])->first();
        $tournamentValues = $this->searchParticipant($attributes, $event);
        $value = DB::table(TABLE_TOURNAMENT_VALUES)
            ->where([
            'tournament_id'                 => $tournament->id,
            $tournamentValues->recorded_in  => $tournamentValues[$tournamentValues->recorded_in]
        ]);
        $value->update([
            'participants_passes' => $tournamentValues[$tournamentValues->recorded_in]
        ]);
        return $value->first();
    }
}
