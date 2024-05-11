<?php

namespace App\Repository\Traits;

use App\Exceptions\Users\RegistrationUserException;
use Exception;
use Illuminate\Database\Eloquent\Model;

trait CreateQueryTrait
{
    /**
     * @param array $attributes
     * @return Model|Exception
     */
    public function store(array $attributes): Model|Exception
    {
        return gettype(get_class($this)) === 'string' && method_exists($this, 'store') ?
            $this->model::create($attributes)
            : new RegistrationUserException('Проверьте данные и повторите попытку.');
    }
}
