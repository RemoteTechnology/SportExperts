<?php

namespace App\Domain\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface FilterRepositoryInterface
{
    /**
     * @param mixed $attributes
     * @param bool $sorted
     * @param string $mode
     * @return Collection|Model|null
     */
    public function query(mixed $attributes, bool $sorted=false, string $mode='one'): Collection|Model|null;
}
