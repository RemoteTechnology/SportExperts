<?php

namespace App\Repository\Traits;

use Illuminate\Database\Eloquent\Model;

trait InviteUserQueryTrait
{
    public function filter(int $user_id): Model
    {
        return $this->eloquentQuery()->where(['user_id' => $user_id])->first();
    }
}