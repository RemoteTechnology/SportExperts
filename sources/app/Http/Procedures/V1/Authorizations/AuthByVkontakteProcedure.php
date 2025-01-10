<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Authorizations;

use App\Domain\Abstracts\AbstractProcedure;
use App\Http\Requests\Auth\LoginByVKontakteRequest;
use App\Http\Resources\AuthResource;
use App\Models\ModelConvert\VkUserConvert;
use App\Services\AuthService;
use App\Services\VK_APIService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

require_once dirname(__DIR__, 4) . '/Domain/Constants/ProcedureNameConst.php';
require_once dirname(__DIR__, 4) . '/Domain/Constants/FieldConst.php';

class AuthByVkontakteProcedure extends AbstractProcedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = PROCEDURE_AUTH_BY_VKONTAKTE;
    private VK_APIService $VK_APIService;
    private AuthService $authService;

    public function __construct(VK_APIService $VK_APIService, AuthService $authService)
    {
        $this->VK_APIService = $VK_APIService;
        $this->authService = $authService;
    }

    /**
     * Execute the procedure.
     *
     * @param LoginByVKontakteRequest $request
     * @return JsonResponse
     */
    public function handle(LoginByVKontakteRequest $request): JsonResponse
    {
        define('ATTRIBUTES', $request->validated());
        $vkService = $this->VK_APIService->getUser(ATTRIBUTES);
        $preparedData = new VkUserConvert($vkService['response'][0]);
        $service = $this->authService->createOrAuthSocial($preparedData());

        return new JsonResponse(
            data: [
                FIELD_ID => self::identifier(),
                new AuthResource($service),
                ...self::meta($request, ATTRIBUTES)
            ],
            status: Response::HTTP_CREATED
        );
    }
}
