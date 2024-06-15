<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Inviteds;

use App\Http\Requests\Inviteds\NotificationRequest;
use App\Services\MailingService;
use Illuminate\Http\JsonResponse;
use Sajya\Server\Procedure;

require_once dirname(__DIR__, 4) . '/Domain/Constants/FieldConst.php';

class NotificationProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'NotificationProcedure';
    private MailingService $mailingService;

    public function __construct(MailingService $mailingService)
    {
        $this->mailingService = $mailingService;
    }

    /**
     * Execute the procedure.
     *
     * @param NotificationRequest $request
     *
     * @return JsonResponse
     */
    public function handle(NotificationRequest $request): JsonResponse
    {
        $invite = $request->validated();
        return new JsonResponse(
            data: $this->mailingService->mailInvitedOrRecord([FIELD_EMAIL => $invite[FIELD_EMAIL]]),
            status: 201
        );
    }
}
