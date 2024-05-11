<?php

namespace App\Domain\Interfaces\Repositories\Queries;

use Illuminate\Database\Eloquent\Model;

interface UpdateQueryInterface
{
    /**
     * @param Model $entity
     * @param array $attributes
     * @return Model
     */
    public function update(Model $entity, array $attributes): Model;
}
