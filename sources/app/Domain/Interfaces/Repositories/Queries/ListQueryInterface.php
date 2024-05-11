<?php

namespace App\Domain\Interfaces\Repositories\Queries;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ListQueryInterface
{
    /**
     * @return Collection<Model>
     */
    public function list(): Collection;
}
