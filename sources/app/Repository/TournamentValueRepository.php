<?php

namespace App\Repository;

use App\Domain\Interfaces\Repositories\LCRUD_OperationInterface;
use App\Models\Event;
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

    /**
     * @param Model $event
     * @param array $attributes
     * @return array
     */
    public function removeParticipant(Model $event, array $attributes): array
    {
        $tournament = Tournament::where(['event_key' => $event->key])->first();
        $participants = array_key_exists('participants_A', $attributes) ? 'participants_A' : 'participants_B';
        $tournamentValues = $this->model::where([
            'tournament_id'     => $tournament->id,
            $participants       => $attributes[$participants]
        ])->latest('id')->first();

        // Если у "participants_A" есть соперник, меняем "participants_A" на значение из "participants_B"
        // саму колонку "participants_B" затирем
        if (
            $participants === 'participants_A' &&
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
            $participants === 'participants_A' &&
            !is_null($tournamentValues->participants_A) &&
            is_null($tournamentValues->participants_B)
        )
        {
            $tournamentValueQuery = $tournamentValues;
            $tournamentValueQuery->delete();
        }
        // Если принимаем "participants_B" то тупо его убираем
        elseif ($participants === 'participants_B')
        {
            $tournamentValues->participants_B = null;
            $tournamentValues->save();
        }
        return $tournamentValues;
    }

    /**
     * @param Model $event
     * @param array $attributes
     * @return array
     */
    public function replaceParticipant(Model $event, array $attributes): array
    {
        $tournament = Tournament::where(['event_key' => $event->key])->first();
        $tournamentValues = DB::select(/** @lang text */ "
            SELECT * FROM tournament_values AS tv
            WHERE tv.tournament_id = {$tournament->id} AND
                tv.participants_A = '{$attributes['participant_key']}' OR
                tv.participants_B = '{$attributes['participant_key']}'
            ORDER BY tv.id DESC
            LIMIT 1;
        ");

        if ($tournamentValues->participants_A === $attributes['participant_key']) $tournamentValues->participants_A = $attributes['new_participant_key'];
        if ($tournamentValues->participants_B === $attributes['participant_key']) $tournamentValues->participants_B = $attributes['new_participant_key'];
        $tournamentValues->save();
        return $tournamentValues;
    }

    public function advanceSkipValue(Model $event, $attributes)
    {
        $tournament = Tournament::where(['event_key' => $event->key])->first();
        $participantColumnName = array_key_exists('participants_A', $attributes) ? 'participants_A' : 'participants_B';
        $tournamentValue = TournamentValue::where([
            'tournament_id'         => $tournament->id,
            $participantColumnName  => $attributes[$participantColumnName]
        ]);
        $tournamentValue->participants_passes = $attributes[$participantColumnName];
        $tournamentValue->save();
        return $tournamentValue;
    }
}
