<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Options;

use App\Http\Requests\Options\ReadOptionRequest;
use App\Http\Resources\Options\OptionResource;
use App\Repository\OptionRepository;
use Illuminate\Http\JsonResponse;
use Sajya\Server\Procedure;

class OptionReadProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'OptionReadProcedure';

    private OptionRepository $operation;

    public function __construct(OptionRepository $operation) {
        $this->operation = $operation;
    }

    /**
     * Execute the procedure.
     *
     * @param ReadOptionRequest $request
     *
     * @return JsonResponse
     */
    public function handle(ReadOptionRequest $request): JsonResponse
    {
        $option = $request->validated();
        return new JsonResponse(
            data: new OptionResource(
                $this->operation->findById($option['id'])
            ),
            status: 201
        );
    }
}
