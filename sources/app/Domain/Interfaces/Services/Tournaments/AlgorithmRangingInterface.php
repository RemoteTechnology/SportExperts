<?php

namespace App\Domain\Interfaces\Services\Tournaments;

use Illuminate\Database\Eloquent\Collection;

interface AlgorithmRangingInterface
{
    /**
     * @param Collection $dataSet
     * @return void
     */
    public function init(Collection $dataSet): void;

    /**
     * @param string $event_key
     * @return array
     */
    public function ranging(string $event_key): array;
}
