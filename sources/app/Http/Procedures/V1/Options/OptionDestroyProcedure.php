<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Options;

use App\Domain\Interfaces\Repositories\Entities\OptionRepositoryInterface;
use App\Http\Resources\Options\OptionResource;
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

    private OptionRepositoryInterface $operation;

    public function __construct(OptionRepositoryInterface $operation) {
        $this->operation = $operation;
    }

    /**
     * Execute the procedure.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function handle(int $id)
    {
        return new JsonResponse(
            data: new OptionResource(
                $this->operation->destroy(
                    $this->operation->findById($id)
                )
            ),
            status: 200
        );
    }
}
