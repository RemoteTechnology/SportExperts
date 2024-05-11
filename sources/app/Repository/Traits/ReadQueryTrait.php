<?php

namespace App\Repository\Traits;

use Illuminate\Database\Eloquent\Model;

trait ReadQueryTrait
{
    /**
     * @param int $id
     * @return Model
     */
    public function findById(int $id): Model
    {
        return get_class($this)->model::find($id);
    }
}
