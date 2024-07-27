<?php

namespace App\Services\Tournaments;

use App\Domain\Abstracts\AbstractAlgorithmRanging;
use App\Domain\Interfaces\Services\Tournaments\AlgorithmRangingInterface;
use App\Models\Event;
use App\Models\Participant;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class AlgorithmRanging extends AbstractAlgorithmRanging implements
    AlgorithmRangingInterface
{
    const WEIGHT_DISCREPANCY = 5;
    const HEIGHT_DISCREPANCY = 3;
    public function getParticipants(string $key): Model
    {
        return $this->participantRepository->findByKey($key);
    }

    public function getOptions(string $key): Model
    {
        return $this->optionRepository->findByKey($key);
    }

    function getTournament(string $key): Model|null
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

    private function discrepancy($optionAthlete1, $optionAthlete2)
    {
        if ($optionAthlete1 > $optionAthlete2)
        {
            return ($optionAthlete1 - $optionAthlete2);
        }
        elseif ($optionAthlete2 > $optionAthlete1)
        {
            return ($optionAthlete2 - $optionAthlete1);
        }
    }

    public function ranging(string $event_key): array
    {
        $tournament = $this->getTournament($event_key);

        if (is_null($tournament))
        {
            $event = Event::where(['key' => $event_key])->first();
            if (count($this->interiorData) == 0)
            {
                $this->outputData[] = [
                    'participants_A' => Participant::where(['event_id' => $event->id])->first(),
                    'participants_B' => null
                ];
                return $this->outputData;
            }
            $this->outputData[] = [
                'participants_A' => $this->interiorData[0]['participant']->key,
                'participants_B' => null
            ];
            return $this->outputData;
        }
        $this->init($this->getTournamentValue($tournament->key));

        for ($i=0; $i < count($this->interiorData); $i++)
        {
            for ($y=count($this->interiorData) - 1; $y >= 0; $y--)
            {
                if (
                    $this->interiorData[$i]['participant'] !== $this->interiorData[$y]['participant']
                    && empty($this->interiorData[$i]['option'])
                    && empty($this->interiorData[$y]['option'])
                    && is_null($this->interiorData[$i]['option']['name'] == 'Weight')
                    && is_null($this->interiorData[$i]['option']['name'] == 'Height')
                    && is_null($this->interiorData[$y]['option']['name'] == 'Weight')
                    && is_null($this->interiorData[$y]['option']['name'] == 'Height')
                )
                {
                    $discrepancyWeigh = $this->discrepancy($this->interiorData[$i]['option']['Weight'], $this->interiorData[$y]['option']['Weight']);
                    $discrepancyHeight = $this->discrepancy($this->interiorData[$i]['option']['Height'], $this->interiorData[$y]['option']['Height']);

                    if ($discrepancyWeigh < self::WEIGHT_DISCREPANCY && $discrepancyHeight < self::HEIGHT_DISCREPANCY)
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
