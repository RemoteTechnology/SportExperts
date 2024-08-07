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
     * @param Model $event
     * @param Model $tournament
     * @param ParticipantRepository $participantRepository
     * @return void
     */
    public function ranging(
        Model $event,
        Model $tournament,
        ParticipantRepository $participantRepository
    ): void
    {
        $values =  $this->tournamentValueRepository->findByTournamentValue($tournament->id);
        $participants = $participantRepository->findByEventId($event->id);
        if (count($values) === 0)
        {
            foreach ($participants as $participant)
            {
                $this->tournamentValueRepository->store([
                    'tournament_id'         => $tournament->id,
                    'participants_A'        => $participant->key,
                    'participants_B'        => null,
                    'participants_passes'   => null,
                ]);
            }
        }
        else
        {
            for ($a=0; $a >= count($participants); $a++)
            {
                $participantAOptions        = $this->optionRepository->findByUserId($participants[$a]->id);
                for ($b = count($participants) - 1; $b >= 0; $b--) {
                    $participantBOptions    = $this->optionRepository->findByUserId($participants[$b]->id);
                    // TODO: проверить что $participants[$a] и $participants[$b] не стоят в парах
                    // TODO: проверить параметры рост, вес, возраст и если всё ок то ебнуть пару!!!
                    $this->tournamentValueRepository->store([
                        'tournament_id'         => $tournament->id,
                        'participants_A'        => $participants[$a]->key,
                        'participants_B'        => $participants[$b]->key,
                        'participants_passes'   => null,
                    ]);
                }
            }
        }
    }
}
