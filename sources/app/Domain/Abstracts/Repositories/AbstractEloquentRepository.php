<?php

namespace App\Domain\Abstracts\Repositories;


use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of Model
 */
abstract class AbstractEloquentRepository
{
    /**
     * @return Model
     */
    abstract protected function eloquentQuery(): Model;
}
