<?php

namespace App\Repository\Traits;

use Illuminate\Database\Eloquent\Model;

trait DestroyQueryTrait
{
    /**
     * @param Model $entity
     * @return bool
     */
    public function destroy(Model $entity): bool
    {
        return $entity->delete();
    }
}
