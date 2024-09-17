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

class OptionDestroyProcedure extends AbstractProcedure
{
    public static string $name = PROCEDURE_OPTION_DESTROY;
    private OptionRepository $operation;

    public function __construct(OptionRepository $operation) {
        $this->operation = $operation;
    }

    /**
     * @param ReadOptionRequest $request
     * @return JsonResponse
     */
    public function handle(ReadOptionRequest $request)
    {
        define('ATTRIBUTES', $request->validated());
        $option = $this->operation->findById(ATTRIBUTES[FIELD_ID]);
        $repository = $this->operation->destroy($option);

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
