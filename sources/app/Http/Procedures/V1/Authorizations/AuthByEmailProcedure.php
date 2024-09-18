<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Authorizations;

use App\Domain\Abstracts\AbstractProcedure;
use App\Http\Requests\Auth\LoginByEmailRequest;
use App\Http\Resources\AuthResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

require_once dirname(__DIR__, 4) . '/Domain/Constants/ProcedureNameConst.php';

class AuthByEmailProcedure extends AbstractProcedure
{
    public static string $name = PROCEDURE_AUTH_BY_EMAIL;
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
        define('ATTRIBUTES', $request->validated());
        $service = $this->authService->authorization(ATTRIBUTES);

        return new JsonResponse(
            data: [
                FIELD_ID => self::identifier(),
                FIELD_ATTRIBUTES => new AuthResource($service),
                ...self::meta($request, ATTRIBUTES)
            ],
            status: Response::HTTP_CREATED
        );
    }
}
