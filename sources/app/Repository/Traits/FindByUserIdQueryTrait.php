<?php

namespace App\Repository\Traits;

use Illuminate\Database\Eloquent\Collection;

trait FindByUserIdQueryTrait
{
    public function userList(int $event_id): Collection
    {
        return $this->eloquentQuery()->where(['event_id' => $event_id])->get();
    }
}
