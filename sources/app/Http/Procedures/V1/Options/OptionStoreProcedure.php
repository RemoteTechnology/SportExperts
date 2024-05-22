<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Options;

use App\Http\Requests\Options\StoreOptionRequest;
use App\Http\Resources\ParametrResource;
use App\Repository\OptionRepository;
use Illuminate\Http\JsonResponse;
use Sajya\Server\Procedure;

class OptionStoreProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'OptionStoreProcedure';

    private OptionRepository $operation;

    public function __construct(OptionRepository $operation) {
        $this->operation = $operation;
    }

    /**
     * Execute the procedure.
     *
     * @param StoreOptionRequest $request
     *
     * @return JsonResponse
     */
    public function handle(StoreOptionRequest $request): JsonResponse
    {
        return new JsonResponse(
            data: new ParametrResource(
                $this->operation->store(
                    $request->validated()
                )
            ),
            status: 201
        );
    }
}
