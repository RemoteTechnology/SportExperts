<?php

namespace App\Domain\Interfaces\Repositories;

use App\Domain\Interfaces\Repositories\Queries\CreateQueryInterface;
use App\Domain\Interfaces\Repositories\Queries\DestroyQueryInterface;
use App\Domain\Interfaces\Repositories\Queries\ListQueryInterface;
use App\Domain\Interfaces\Repositories\Queries\ReadQueryInterface;
use App\Domain\Interfaces\Repositories\Queries\UpdateQueryInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * @template T of Model
 */
interface LCRUD_OperationInterface extends
    ListQueryInterface,
    CreateQueryInterface,
    ReadQueryInterface,
    UpdateQueryInterface,
    DestroyQueryInterface
{
}
