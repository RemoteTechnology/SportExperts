<?php

namespace App\Repository\Traits;

use Illuminate\Database\Eloquent\Collection;

require_once dirname(__DIR__, 2) . '/Domain/Constants/FieldConst.php';
require_once dirname(__DIR__, 2) . '/Domain/Constants/EventStatusesConst.php';

trait ListQueryTrait
{
    /**
     * @param string $mode
     * @return Collection
     */
    public function list(string $mode='list'): mixed
    {
        return $mode === 'list'
            ? $this->model::all()
            : $this->model
                ->where([FIELD_STATUS => EVENT_ACTIVE])
                ->orderByDesc(FIELD_START_DATE)
                ->orderByDesc(FIELD_START_TIME)
                ->paginate(12);

    }
}
