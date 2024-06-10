<?php

namespace App\Repository\Traits;

use Illuminate\Database\Eloquent\Model;

require_once dirname(__DIR__, 2) . '/Domain/Constants/FieldConst.php';

trait StatusQueryTrait
{
    /**
     * @param array $attributes
     * @param string $status
     * @return Model
     */
    public function updateStatus(array $attributes, string $status): Model
    {
        $event = $this->model::where([FIELD_KEY => $attributes[FIELD_KEY]])->first();
        $event->status = $status;
        $event->save();
        return $event;
    }
}
