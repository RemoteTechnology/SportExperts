<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Inviteds;

use App\Domain\Abstracts\AbstractProcedure;
use App\Http\Requests\Inviteds\ReadInvitedRequest;
use App\Http\Resources\Inviteds\InvitedResource;
use App\Repository\InvitedRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

require_once dirname(__DIR__, 4) . '/Domain/Constants/ProcedureNameConst.php';
require_once dirname(__DIR__, 4) . '/Domain/Constants/FieldConst.php';

class InvitedReadProcedure extends AbstractProcedure
{
    public static string $name = PROCEDURE_INVITE_READ;
    private InvitedRepository $invitedRepository;

    public function __construct(InvitedRepository $invitedRepository) {
        $this->invitedRepository = $invitedRepository;
    }

    /**
     * @param ReadInvitedRequest $request
     * @return JsonResponse
     */
    public function handle(ReadInvitedRequest $request): JsonResponse
    {
        define('ATTRIBUTES', $request->validated());
        $repository = $this->invitedRepository->findById(ATTRIBUTES[FIELD_ID]);

        return new JsonResponse(
            data: [
                FIELD_ID => self::identifier(),
                FIELD_ATTRIBUTES => new InvitedResource($repository),
                ...self::meta($request, ATTRIBUTES)
            ],
            status: Response::HTTP_CREATED
        );
    }
}
