<?php

namespace App\Repository\Traits;

use Illuminate\Database\Eloquent\Collection;

trait ListQueryTrait
{
    /**
     * @param string $mode
     * @return Collection
     */
    public function list(string $mode='list'): mixed
    {
        return $mode === 'list'
            ? $this->model::all()
            : $this->model
                ->orderBy('start_date', 'desc')
                ->orderBy('start_time', 'desc')
                ->orderByDesc('start_date')
                ->orderByDesc('start_time')
                ->paginate(12);

    }
}
