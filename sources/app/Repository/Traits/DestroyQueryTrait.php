<?php

namespace App\Repository\Traits;

use Illuminate\Database\Eloquent\Model;

trait DestroyQueryTrait
{
    /**
     * @param Model $entity
     * @return Model
     */
    public function destroy(Model $entity): bool
    {
        return $entity->delete();
    }
}
