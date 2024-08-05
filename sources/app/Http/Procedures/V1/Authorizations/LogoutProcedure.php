<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Authorizations;

use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Sajya\Server\Procedure;

class LogoutProcedure extends Procedure
{
    public static string $name = 'LogoutProcedure';
    private AuthService $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function handle(Request $request)
    {
        return new JsonResponse(
            $this->authService->logout($request->user())
        );
    }
}
