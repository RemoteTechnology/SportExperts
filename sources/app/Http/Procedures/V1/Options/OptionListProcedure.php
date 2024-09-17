<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Options;

use App\Domain\Abstracts\AbstractProcedure;
use App\Http\Resources\Options\OptionCollection;
use App\Repository\OptionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

require_once dirname(__DIR__, 4) . '/Domain/Constants/ProcedureNameConst.php';
require_once dirname(__DIR__, 4) . '/Domain/Constants/FieldConst.php';

class OptionListProcedure extends AbstractProcedure
{
    public static string $name = PROCEDURE_OPTION_LIST;
    private OptionRepository $optionRepository;

    public function __construct(OptionRepository $optionRepository) {
        $this->optionRepository = $optionRepository;
    }

    /**
     * @return JsonResponse
     */
    public function handle(Request $request): JsonResponse
    {
        $repository = $this->optionRepository->list(FIELD_PAGINATE);
        $collectData = new OptionCollection($repository);

        return new JsonResponse(
            data: [
                FIELD_ID => self::identifier(),
                FIELD_ATTRIBUTES => $collectData->resource,
                ...self::meta($request, [])
            ],
            status: Response::HTTP_CREATED
        );
    }
}
