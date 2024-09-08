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
    public function list(
        string $mode='list',
        bool $status = false,
        bool $currentDateTime = false
    ): mixed
    {
        if ($mode === 'list')
        {
            return $this->model::all();
        }

        if ($status) $this->model->where([FIELD_STATUS => EVENT_ACTIVE]);
        if ($currentDateTime)  $this->model->orderByDesc(FIELD_START_DATE)->orderByDesc(FIELD_START_TIME);
        return $this->model->paginate(12);

    }
}
