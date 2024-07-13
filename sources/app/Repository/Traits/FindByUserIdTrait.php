<?php

namespace App\Repository\Traits;

use Illuminate\Database\Eloquent\Model;

trait FindByUserIdTrait
{
    /**
     * @param int $user_id
     * @return Model
     */
    public function findByUserId(int $user_id): Model
    {
        return $this->model::where(['user_id' => $user_id])->first();
    }
}
