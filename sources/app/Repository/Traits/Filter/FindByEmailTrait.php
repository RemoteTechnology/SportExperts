<?php

namespace App\Repository\Traits\Filter;

use App\Domain\Abstracts\Repositories\AbstractEloquentRepository;
use App\Exceptions\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

require_once dirname(__DIR__, 3) . '/Domain/Constants/FieldConst.php';

trait FindByEmailTrait
{
    /**
     * @param string $email
     * @return Model
     */
    public function findByEmailQuery(string $email): Model
    {
        return $this->eloquentQuery()->where([FIELD_EMAIL => $email])->first();
    }
}
