<?php

namespace App\Domain\Interfaces\Repositories\Queries;

use Illuminate\Database\Eloquent\Model;

interface ReadQueryInterface
{
    /**
     * @param int $id
     * @return Model
     */
    public function findById(int $id): Model;
}
