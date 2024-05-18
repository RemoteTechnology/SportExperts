<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Options;

use App\Domain\Interfaces\Repositories\Entities\OptionRepositoryInterface;
use App\Http\Resources\ParametrResource;
use Illuminate\Http\JsonResponse;
use Sajya\Server\Procedure;

class OptionListProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'OptionListProcedure';

    private OptionRepositoryInterface $operation;

    public function __construct(OptionRepositoryInterface $operation) {
        $this->operation = $operation;
    }

    /**
     * Execute the procedure.
     *
     * @return JsonResponse
     */
    public function handle(): JsonResponse
    {
        return new JsonResponse(
            data: ParametrResource::collection(
                $this->operation->list()
            ),
            status: 200
        );
    }
}
