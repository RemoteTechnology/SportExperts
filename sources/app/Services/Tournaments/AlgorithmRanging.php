<?php

namespace App\Services\Tournaments;

use App\Domain\Abstracts\AbstractAlgorithmRanging;
use App\Domain\Interfaces\Services\Tournaments\AlgorithmRangingInterface;
use App\Models\Event;
use App\Models\Participant;
use App\Repository\OptionRepository;
use App\Repository\ParticipantRepository;
use App\Repository\TournamentValueRepository;
use App\Repository\UserRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class AlgorithmRanging extends AbstractAlgorithmRanging
{
    const WEIGHT_DISCREPANCY = 5;
    const HEIGHT_DISCREPANCY = 3;
    const AGE_DISCREPANCY = 2;
    private OptionRepository $optionRepository;
    private UserRepository $userRepository;
    private TournamentValueRepository $tournamentValueRepository;

    public function __construct(
        TournamentValueRepository $tournamentValueRepository,
        OptionRepository $optionRepository,
        UserRepository $userRepository
    )
    {
        $this->tournamentValueRepository    = $tournamentValueRepository;
        $this->optionRepository             = $optionRepository;
        $this->userRepository               = $userRepository;
    }

    /**
     * @param Model $participant
     * @param Model $tournament
     * @return Model
     */
    private function addTournamentValue(Model $participant, Model|null $tournament): Model
    {
        return $this->tournamentValueRepository->store([
            'tournament_id' => $tournament->id,
            'participants_A' => $participant->key,
            'participants_B' => null,
            'participants_passes' => null,
        ]);
    }

    /**
     * @param Collection $participants
     * @param Model $participant
     * @param Model $tournament
     */
    public function addRivalExists(Collection $participants, Model $participant, Model $tournament)
    {
        // Параметры текущего спортсмена
        $athleteWeight = $this->optionRepository->queryExists(['user_id' => $participant->user_id, 'name' => 'Weight']);
        $athleteHeight = $this->optionRepository->queryExists(['user_id' => $participant->user_id, 'name' => 'Height']);
        $athleteAge = Carbon::parse($this->userRepository->findById($participant->user_id)->birth_date);

        foreach ($participants as $item)
        {
            if ($participant->key !== $item->key)
            {
                // Параметры соперника
                $participantWeight = $this->optionRepository->queryExists(['user_id' => $item->user_id, 'name' => 'Weight']);
                $participantHeight = $this->optionRepository->queryExists(['user_id' => $item->user_id, 'name' => 'Height']);
                $participantAge = Carbon::parse($this->userRepository->findById($item->user_id)->birth_date);

                $weight = abs((int)$athleteWeight->value - (int)$participantWeight->value);
                $height = abs((int)$athleteHeight->value - (int)$participantHeight->value);
                $age = $athleteAge->diffInYears($participantAge);


                if (($weight <= self::WEIGHT_DISCREPANCY) && ($height <= self::HEIGHT_DISCREPANCY) && ($age <= self::AGE_DISCREPANCY))
                {
                    $tournamentValue = $this->tournamentValueRepository->queryExists(['participants_A' => $item->key]);
                    return $this->tournamentValueRepository->update($tournamentValue, [
                        'participants_B' => $participant->key
                    ]);
                }
            }
        }

        return $this->addTournamentValue($participant, $tournament);
    }

    /**
     * @param Model $event
     * @param Model|null $tournament
     * @param ParticipantRepository $participantRepository
     * @param Model $participant
     * @return Model|void
     */
    public function ranging(
        Model $event,
        Model|null $tournament,
        ParticipantRepository $participantRepository,
        Model $participant
    )
    {
        $values =  $this->tournamentValueRepository->findByTournamentValue($tournament->id);
        $participants = $participantRepository->findByEventId($event->id);
        if (count($values) === 0)
        {
            foreach ($participants as $item) {
                return $this->addTournamentValue($item, $tournament);
            }
        }
        else
        {
            return $this->addRivalExists($participants, $participant, $tournament);
        }
    }
}
