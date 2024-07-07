<?php

namespace App\Domain\Abstracts;

use App\Repository\OptionRepository;
use App\Repository\ParticipantRepository;
use App\Repository\TournamentRepository;
use App\Repository\TournamentValueRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractAlgorithmRanging
{
    // Итоговый массив
    public array $outputData = []; // $outputData = [];
    // Массив для временного хрпнения
    public array $interiorData = [];

    protected ParticipantRepository $participantRepository;
    protected OptionRepository $optionRepository;
    protected TournamentRepository $tournamentRepository;
    protected TournamentValueRepository $tournamentValueRepository;
    public function __construct(
        ParticipantRepository $participantRepository,
        OptionRepository $optionRepository,
        TournamentRepository $tournamentRepository,
        TournamentValueRepository $tournamentValueRepository
    )
    {
        $this->participantRepository = $participantRepository;
        $this->optionRepository = $optionRepository;
        $this->tournamentRepository = $tournamentRepository;
        $this->tournamentValueRepository = $tournamentValueRepository;
    }

    abstract function getParticipants(string $key): Model;
    abstract function getOptions(string $key): Model;
    abstract function getTournament(string $key): Model;
    abstract function getTournamentValue(string $key): Collection;
}
