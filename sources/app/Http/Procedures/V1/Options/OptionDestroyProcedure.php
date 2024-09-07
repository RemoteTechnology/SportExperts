<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Options;

use App\Domain\Interfaces\Repositories\Entities\OptionRepositoryInterface;
use App\Http\Requests\Options\ReadOptionRequest;
use App\Http\Resources\Options\OptionResource;
use App\Repository\OptionRepository;
use Illuminate\Http\JsonResponse;
use Sajya\Server\Procedure;

class OptionDestroyProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'OptionDestroyProcedure';

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
    public function handle(ReadOptionRequest $request)
    {
        $attributes = $request->validated();
        return new JsonResponse(
            data: new OptionResource(
                $this->operation->destroy(
                    $this->operation->findById($attributes['id'])
                )
            ),
            status: 200
        );
    }
}
