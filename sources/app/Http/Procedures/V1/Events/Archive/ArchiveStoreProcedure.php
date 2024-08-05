<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Events\Archive;

use App\Http\Requests\Archives\ArchiveRequest;
use App\Http\Resources\Events\EventResource;
use App\Repository\EventRepository;
use Illuminate\Http\JsonResponse;
use Sajya\Server\Procedure;

require_once dirname(__DIR__, 5) . '/Domain/Constants/EventStatusesConst.php';

class ArchiveStoreProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'ArchiveStoreProcedure';
    public EventRepository $repository;

    public function __construct(EventRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Execute the procedure.
     *
     * @param ArchiveRequest $request
     *
     * @return JsonResponse
     */
    public function handle(ArchiveRequest $request): JsonResponse
    {
        $archive = $request->validated();
        return new JsonResponse(
            data: new EventResource(
                $this->repository->updateStatus($archive, EVENT_ARCHIVE)
            ),
            status: 201
        );
    }
}
