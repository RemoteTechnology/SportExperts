<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Events;

use App\Domain\Interfaces\Repositories\Entities\EventRepositoryInterface;
use App\Http\Resources\EventResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Sajya\Server\Procedure;

class EventReadProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'EventReadProcedure';

    private EventRepositoryInterface $operation;

    public function __construct(EventRepositoryInterface $operation) {
        $this->operation = $operation;
    }

    /**
     * Execute the procedure.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function handle(int $id): JsonResponse
    {
        return new JsonResponse(
            data: new EventResource(
                $this->operation->findById($id)
            ),
            status: 200
        );
    }
}
