<?php

namespace App\Repository\Traits;

use Illuminate\Database\Eloquent\Model;

require_once dirname(__DIR__, 2) . '/Domain/Constants/FieldConst.php';

trait FindByEventKeyTrait
{
    /**
     * @param string $event_key
     * @return Model
     */
    public function findByEventKey(string $event_key): Model
    {
        return $this->model::where([FIELD_EVENT_KEY => $event_key])->first();
    }
}
