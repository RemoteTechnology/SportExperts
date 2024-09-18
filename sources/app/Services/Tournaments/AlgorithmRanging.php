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

require_once dirname(__DIR__, 2) . '/Domain/Constants/FieldConst.php';

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
            FIELD_TOURNAMENT_ID         => $tournament->id,
            FIELD_PARTICIPANTS_A        => $participant->key,
            FIELD_PARTICIPANTS_B        => null,
            FIELD_PARTICIPANTS_PASSES   => null,
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
        $athleteWeight = $this->optionRepository->queryExists([
            FIELD_USER_ID => $participant->user_id,
            FIELD_NAME => 'Weight'
        ]);
        $athleteHeight = $this->optionRepository->queryExists([
            FIELD_USER_ID => $participant->user_id,
            FIELD_NAME => 'Height'
        ]);
        $athleteAge = Carbon::parse($this->userRepository->findById($participant->user_id)->birth_date);

        foreach ($participants as $item)
        {
            if ($participant->key !== $item->key)
            {
                // Параметры соперника
                $participantWeight = $this->optionRepository->queryExists([
                    FIELD_USER_ID => $item->user_id,
                    FIELD_NAME => 'Weight'
                ]);
                $participantHeight = $this->optionRepository->queryExists([
                    FIELD_USER_ID => $item->user_id,
                    FIELD_NAME => 'Height'
                ]);
                $participantAge = Carbon::parse($this->userRepository->findById($item->user_id)->birth_date);

                $weight = abs((int)$athleteWeight->value - (int)$participantWeight->value);
                $height = abs((int)$athleteHeight->value - (int)$participantHeight->value);
                $age = $athleteAge->diffInYears($participantAge);


                if (($weight <= self::WEIGHT_DISCREPANCY) && ($height <= self::HEIGHT_DISCREPANCY) && ($age <= self::AGE_DISCREPANCY))
                {
                    $tournamentValue = $this->tournamentValueRepository->queryExists([FIELD_PARTICIPANTS_A => $item->key]);
                    return $this->tournamentValueRepository->update($tournamentValue, [
                        FIELD_PARTICIPANTS_B => $participant->key
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
