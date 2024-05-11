<?php

namespace App\Domain\Abstracts\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of Model
 * @template TParentModel of Model
 * @extends AbstractEloquentRepository<TModel>
 */
abstract class AbstractEloquentDependentRepository extends AbstractEloquentRepository
{
    /**
     * @return Builder
     */
    abstract protected function parentEloquentQuery(): Builder;
}
