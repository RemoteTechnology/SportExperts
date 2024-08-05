<?php

namespace App\Repository\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait FindByUserIdTrait
{
    /**
     * @param int $user_id
     * @return Model|Collection
     */
    public function findByUserId(int $user_id): Model|Collection
    {
        return $this->model::where(['user_id' => $user_id])->get();
    }
}
