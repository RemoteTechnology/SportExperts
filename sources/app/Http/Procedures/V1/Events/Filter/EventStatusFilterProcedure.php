<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Events\Filter;

use Illuminate\Http\Request;
use Sajya\Server\Procedure;

class EventStatusFilterProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'EventStatusFilterProcedure';

    /**
     * Execute the procedure.
     *
     * @param Request $request
     *
     * @return array|string|integer
     */
    public function handle(Request $request)
    {
        // write your code
    }
}
