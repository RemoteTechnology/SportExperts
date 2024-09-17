<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Authorizations;

use App\Domain\Abstracts\AbstractProcedure;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

require_once dirname(__DIR__, 4) . '/Domain/Constants/ProcedureNameConst.php';

class LogoutProcedure extends AbstractProcedure
{
    public static string $name = PROCEDURE_LOGOUT;
    private AuthService $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function handle(Request $request)
    {
        $user = $request->user();
        $service = $this->authService->logout($user);

        return new JsonResponse(
            data: [
                FIELD_ID => self::identifier(),
                FIELD_ATTRIBUTES => $service,
                ...self::meta($request, [])
            ],
            status: Response::HTTP_CREATED
        );
    }
}
