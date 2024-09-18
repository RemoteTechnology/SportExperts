<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Options;

use App\Domain\Abstracts\AbstractProcedure;
use App\Http\Requests\Options\StoreOptionRequest;
use App\Http\Resources\Options\OptionResource;
use App\Repository\OptionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

require_once dirname(__DIR__, 4) . '/Domain/Constants/ProcedureNameConst.php';

class OptionStoreProcedure extends AbstractProcedure
{
    public static string $name = PROCEDURE_OPTION_STORE;
    private OptionRepository $operation;

    public function __construct(OptionRepository $operation) {
        $this->operation = $operation;
    }

    /**
     * @param StoreOptionRequest $request
     * @return JsonResponse
     */
    public function handle(StoreOptionRequest $request)
    {
        define('ATTRIBUTES', $request->validated());
        $repository = $this->operation->store(ATTRIBUTES);

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
