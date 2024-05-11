<?php

namespace App\Repository\Traits;

use Illuminate\Database\Eloquent\Model;

trait UpdateQueryTrait
{
    /**
     * @param Model $entity
     * @param array $attributes
     * @return Model
     */
    public function update(Model $entity, array $attributes): Model
    {
//        $entity->update($attributes);
        return $entity;
    }
}
