<?php

namespace App\Repository;

use App\Domain\Interfaces\Repositories\Queries\CreateQueryInterface;
use App\Domain\Interfaces\Repositories\Queries\DestroyQueryInterface;
use App\Domain\Interfaces\Repositories\Queries\ReadQueryInterface;
use App\Models\File;
use App\Repository\Filter\GetKeyQueryTrait;
use App\Repository\Traits\CreateQueryTrait;
use App\Repository\Traits\DestroyQueryTrait;
use App\Repository\Traits\ReadQueryTrait;
use Illuminate\Database\Eloquent\Model;

class FileRepository implements
    CreateQueryInterface,
    ReadQueryInterface,
    DestroyQueryInterface
{
    use CreateQueryTrait;
    use ReadQueryTrait;
    use DestroyQueryTrait;
    use GetKeyQueryTrait;

    protected Model $model;
    public function __construct(File $model = new File())
    {
        $this->model = $model;
    }
}
