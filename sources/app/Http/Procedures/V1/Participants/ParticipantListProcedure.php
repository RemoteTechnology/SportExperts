<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Participants;

use App\Domain\Interfaces\Repositories\Entities\ParticipantRepositoryInterface;
use App\Http\Resources\ParticipantResource;
use Illuminate\Http\JsonResponse;
use Sajya\Server\Procedure;

class ParticipantListProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'ParticipantListProcedure';

    private ParticipantRepositoryInterface $operation;

    public function __construct(ParticipantRepositoryInterface $operation) {
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