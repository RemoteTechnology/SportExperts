<?php

namespace App\Repository\Traits;

use Illuminate\Database\Eloquent\Model;

trait FindByEventKeyTrait
{
    /**
     * @param string $event_key
     * @return Model
     */
    public function findByEventKey(string $event_key): Model
    {
        return $this->model::where(['event_key' => $event_key])->first();
    }
}
