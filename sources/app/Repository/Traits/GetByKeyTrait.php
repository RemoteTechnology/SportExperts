<?php

namespace App\Repository\Traits;

use Illuminate\Database\Eloquent\Model;

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
