<?php

namespace App\Repository\Traits;

use Illuminate\Database\Eloquent\Model;

// TODO: использовать ToFieldsSearchQueryTrait, больше не использовать GetByKeyTrait, вырезать его
trait GetByKeyTrait
{
    /**
     * @param string $key
     * @return Model
     */
    public function findByKey(string $key): Model
    {
        return $this->model::where(['key' => $key])->first();
    }
}
