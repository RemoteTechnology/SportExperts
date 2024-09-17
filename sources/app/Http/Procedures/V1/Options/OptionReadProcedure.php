<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Options;

use App\Domain\Abstracts\AbstractProcedure;
use App\Http\Requests\Options\ReadOptionRequest;
use App\Http\Resources\Options\OptionResource;
use App\Repository\OptionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

require_once dirname(__DIR__, 4) . '/Domain/Constants/ProcedureNameConst.php';
require_once dirname(__DIR__, 4) . '/Domain/Constants/FieldConst.php';

class OptionReadProcedure extends AbstractProcedure
{
    public static string $name = PROCEDURE_OPTION_READ;
    private OptionRepository $optionRepository;

    public function __construct(OptionRepository $optionRepository) {
        $this->optionRepository = $optionRepository;
    }

    /**
     * @param ReadOptionRequest $request
     * @return JsonResponse
     */
    public function handle(ReadOptionRequest $request): JsonResponse
    {
        define('ATTRIBUTES', $request->validated());
        if (key_exists(FIELD_USER_ID, ATTRIBUTES))
        {
            $repository = $this->optionRepository->findByUserId((int)ATTRIBUTES[FIELD_USER_ID]);

            return new JsonResponse(
                data: [
                    FIELD_ID => self::identifier(),
                    FIELD_ATTRIBUTES => $repository,
                    ...self::meta($request, ATTRIBUTES)
                ],
                status: Response::HTTP_CREATED
            );
        }
        elseif (key_exists(FIELD_EVENT_KEY, ATTRIBUTES))
        {
            $repository = $this->optionRepository->findByEventKey(ATTRIBUTES[FIELD_EVENT_KEY]);

            return new JsonResponse(
                data: [
                    FIELD_ID => self::identifier(),
                    FIELD_ATTRIBUTES => new OptionResource($repository),
                    ...self::meta($request, ATTRIBUTES)
                ],
                status: Response::HTTP_CREATED
            );
        }
        else
        {
            $repository = $this->optionRepository->findById(ATTRIBUTES[FIELD_ID]);

            return new JsonResponse(
                data: [
                    FIELD_ID => self::identifier(),
                    FIELD_ATTRIBUTES => new OptionResource($repository),
                    ...self::meta($request, ATTRIBUTES)
                ],
                status: Response::HTTP_CREATED
            );
        }
    }
}
