<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Participants;

use App\Domain\Interfaces\Repositories\Entities\ParticipantRepositoryInterface;
use App\Http\Resources\Participants\ParticipantResource;
use Illuminate\Http\JsonResponse;
use Sajya\Server\Procedure;

class ParticipantDestroyProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'ParticipantDestroyProcedure';

    private ParticipantRepositoryInterface $operation;

    public function __construct(ParticipantRepositoryInterface $operation) {
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
            data: new ParticipantResource(
                $this->operation->destroy(
                    $this->operation->findById($id)
                )
            ),
            status: 200
        );
    }
}
