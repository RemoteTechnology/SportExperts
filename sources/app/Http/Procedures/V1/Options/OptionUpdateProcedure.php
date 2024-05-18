<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Options;

use App\Domain\Interfaces\Repositories\Entities\OptionRepositoryInterface;
use App\Http\Requests\Options\UpdateOptionRequest;
use App\Http\Resources\ParametrResource;
use Illuminate\Http\JsonResponse;
use Sajya\Server\Procedure;

class OptionUpdateProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'OptionUpdateProcedure';

    private OptionRepositoryInterface $operation;

    public function __construct(OptionRepositoryInterface $operation) {
        $this->operation = $operation;
    }

    /**
     * Execute the procedure.
     *
     * @param UpdateOptionRequest $request
     *
     * @return JsonResponse
     */
    public function handle(UpdateOptionRequest $request): JsonResponse
    {
        $parametr = $request->validated();
        return new JsonResponse(
            data: new ParametrResource(
                $this->operation->update(
                    $this->operation->findById($parametr['id']),
                    $parametr
                )
            ),
            status: 201
        );
    }
}
