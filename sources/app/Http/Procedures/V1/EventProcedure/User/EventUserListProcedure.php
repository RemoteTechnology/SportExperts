<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\EventProcedure\User;

use App\Domain\Interfaces\Repositories\Entities\EventUserRepositoryInterface;
use App\Http\Resources\ParticipantResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Sajya\Server\Procedure;

class EventUserListProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'EventUserListProcedure';

    private EventUserRepositoryInterface $operation;

    public function __construct(EventUserRepositoryInterface $operation) {
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
            data: ParticipantResource::collection(
                $this->operation->list()
            ),
            status: 200
        );
    }
}
