<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Authorizations;

use App\Http\Requests\Auth\LoginByEmailRequest;
use App\Http\Resources\AuthResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Sajya\Server\Procedure;

class AuthByEmailProcedure extends Procedure
{
    public static string $name = 'AuthByEmailProcedure';
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @param LoginByEmailRequest $request
     * @return JsonResponse
     */
    public function handle(LoginByEmailRequest $request): JsonResponse
    {
        return new JsonResponse(
            new AuthResource(
                $this->authService->authorization($request->validated())
            )
        );
    }
}
