<?php

namespace App\Domain\Interfaces\Repositories\Queries;

use Exception;
use Illuminate\Database\Eloquent\Model;

interface CreateQueryInterface
{
    /**
     * @param array $attributes
     * @return Model|Exception
     */
    public function store(array $attributes): Model|Exception;
}
