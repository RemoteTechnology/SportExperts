<?php

namespace App\Repository\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait ListQueryTrait
{
    /**
     * @return Collection<Model>
     */
    public function list(): Collection
    {
        return $this->model::all();
    }
}
