<?php

namespace App\Repository\Traits;

use Illuminate\Database\Eloquent\Model;

/**
 * @template T as Model
 */
trait UpdateQueryTrait
{
    /**
     * @param Model $entity
     * @param array $attributes
     * @return Model
     */
    public function update(Model $entity, array $attributes): Model
    {
        foreach ($attributes as $field => $value)
        {
            if (property_exists($entity, $field) && !is_null($value))
            {
                $entity->$field = $value;
            }
        }
        $entity->save();
        return $entity;
    }
}
