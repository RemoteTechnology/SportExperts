<?php

namespace App\Services\Tournaments;

use App\Domain\Abstracts\AbstractAlgorithmRanging;
use App\Domain\Interfaces\Services\Tournaments\AlgorithmRangingInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class AlgorithmRanging extends AbstractAlgorithmRanging implements
    AlgorithmRangingInterface
{
    public function getParticipants(string $key): Model
    {
        return $this->participantRepository->findByKey($key);
    }

    public function getOptions(string $key): Model
    {
        return $this->optionRepository->findByKey($key);
    }

    function getTournament(string $key): Model
    {
        return $this->tournamentRepository->findByTournamentKey($key);
    }

    function getTournamentValue(string $key): Collection
    {
        return $this->tournamentValueRepository->findByTournamentValueKey($key);
    }

    public function init(Collection $dataSet): void
    {
        // Разделение спортсменов для дальнейшего перераспределения по парам
        if (count($dataSet->toArray()) > 0)
        {
            foreach ($dataSet as $value)
            {
                $this->interiorData[] = [
                    'participant' => $this->getParticipants($value->participants_A),
                    'option' => $this->getOptions($value->participants_A),
                ];
                if (!is_null($value->participants_B))
                {
                    $this->interiorData[] = [
                        'participant' => $this->getParticipants($value->participants_B),
                        'option' => $this->getOptions($value->participants_B),
                    ];
                }
            }
        }
    }

    public function ranging(string $event_key): array
    {
        $tournament = $this->getTournament($event_key);
        $this->init($this->getTournamentValue($tournament->key));

        for ($i=0; $i < count($this->interiorData); $i++)
        {
            for ($y=count($this->interiorData) - 1; $y >= 0; $y--)
            {
                if ($this->interiorData[$i]['participant'] !== $this->interiorData[$y]['participant'])
                {
                    // TODO: после переделки параметров под спортсмена вернться сюда!!!
                    $result = ($this->interiorData[$i]['option'] - $this->interiorData[$y]['option']);
                    if ($result == 0 || $result == 1 || $result == 2)
                    {
                        $this->outputData[] = [
                            'participants_A' => $this->interiorData[$i]['participant']->key,
                            'participants_B' => $this->interiorData[$y]['participant']->key
                        ];
                        unset($this->interiorData[$i]);
                        unset($this->interiorData[$y]);
                    }
                }
            }
        }
        if (count($this->interiorData) == 1)
        {
            $this->outputData[] = [
                'participants_A' => $this->interiorData[0]['participant']->key,
                'participants_B' => null
            ];
        }
        elseif (count($this->interiorData) > 1)
        {
            // TODO: Запустить рассылку о том что вы попали в запасные :)
        }
        return $this->outputData;
    }
}
