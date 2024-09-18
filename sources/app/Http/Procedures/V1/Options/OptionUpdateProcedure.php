<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Options;

use App\Domain\Abstracts\AbstractProcedure;
use App\Http\Requests\Options\UpdateOptionRequest;
use App\Http\Resources\Options\OptionResource;
use App\Repository\OptionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

require_once dirname(__DIR__, 4) . '/Domain/Constants/ProcedureNameConst.php';
require_once dirname(__DIR__, 4) . '/Domain/Constants/FieldConst.php';

class OptionUpdateProcedure extends AbstractProcedure
{
    public static string $name = PROCEDURE_OPTION_UPDATE;
    private OptionRepository $optionRepository;

    public function __construct(OptionRepository $optionRepository) {
        $this->optionRepository = $optionRepository;
    }

    /**
     * @param UpdateOptionRequest $request
     * @return JsonResponse
     */
    public function handle(UpdateOptionRequest $request): JsonResponse
    {
        define('ATTRIBUTES', $request->validated());
        $option = $this->optionRepository->findById(ATTRIBUTES[FIELD_ID]);
        $repository = $this->optionRepository->update($option, ATTRIBUTES);

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
