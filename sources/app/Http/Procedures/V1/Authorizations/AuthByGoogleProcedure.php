<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Authorizations;

use App\Domain\Abstracts\AbstractProcedure;
use App\Http\Requests\Auth\LoginByGoogleRequest;
use App\Http\Resources\AuthResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

require_once dirname(__DIR__, 4) . '/Domain/Constants/ProcedureNameConst.php';
require_once dirname(__DIR__, 4) . '/Domain/Constants/FieldConst.php';

class AuthByGoogleProcedure extends AbstractProcedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = PROCEDURE_AUTH_BY_GOOGLE;

    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @param LoginByGoogleRequest $request
     * @param string $mode
     * @return JsonResponse
     */
    public function handle(LoginByGoogleRequest $request): JsonResponse
    {
        define('ATTRIBUTES', $request->validated());
        $service = $this->authService->createOrAuthSocial(ATTRIBUTES);

        return new JsonResponse(
            data: [
                FIELD_ID => self::identifier(),
                FIELD_ATTRIBUTES => $service,//new AuthResource($service),
                ...self::meta($request, ATTRIBUTES)
            ],
            status: Response::HTTP_CREATED
        );
    }
}
