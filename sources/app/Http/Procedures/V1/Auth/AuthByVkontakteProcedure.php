<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Auth;

use Illuminate\Http\Request;
use Sajya\Server\Procedure;

class AuthByVkontakteProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'AuthByVkontakteProcedure';

    /**
     * Execute the procedure.
     *
     * @param Request $request
     * @param string $mode
     * @return array|string|integer
     */
    public function handle(Request $request, string $mode)
    {
        // write your code
    }
}
