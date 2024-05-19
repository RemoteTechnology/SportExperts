<?php

namespace App\Domain\Interfaces\Services\Tournament;

use Illuminate\Database\Eloquent\Collection;

interface GridBuilderTournamentInterface
{
    /**
     * @param string $schema
     * @return array
     */
    public function init(string $schema): array;

    /**
     * @return Collection<DrawingOfLotsServiceInterface>
     */
    public function builder(): Collection;
}
