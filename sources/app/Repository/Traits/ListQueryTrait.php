<?php

namespace App\Repository\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait ListQueryTrait
{
    /**
     * @param string $mode
     * @return Collection
     */
    public function list(string $mode='list'): mixed
    {
        return $mode === 'list' ? $this->model::all() : $this->model::paginate(10);

    }
}
