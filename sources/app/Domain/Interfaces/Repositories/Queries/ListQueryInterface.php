<?php

namespace App\Domain\Interfaces\Repositories\Queries;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ListQueryInterface
{
    /**
     * @param string $mode
     * @return mixed
     */
    public function list(string $mode='list'): mixed;
}
