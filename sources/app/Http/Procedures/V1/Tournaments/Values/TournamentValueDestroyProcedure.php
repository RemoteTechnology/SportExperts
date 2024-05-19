<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Tournaments\Values;

use Illuminate\Http\Request;
use Sajya\Server\Procedure;

class TournamentValueDestroyProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'TournamentValueDestroyProcedure';

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
