<?php

namespace App\Domain\Interfaces\Services\Tournament;

use Illuminate\Database\Eloquent\Collection;

interface DrawingOfLotsServiceInterface
{
    /**
     * @param Collection $participants
     * @return Collection
     */
    public function aOlympicDraw(Collection $participants): Collection;

    /**
     * @param Collection $participants
     * @return Collection
     */
    public function aCustomDraw(Collection $participants): Collection;
}
