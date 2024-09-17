<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Inviteds;

use App\Domain\Abstracts\AbstractProcedure;
use App\Http\Requests\Inviteds\NotificationRequest;
use App\Services\MailingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

require_once dirname(__DIR__, 4) . '/Domain/Constants/FieldConst.php';
require_once dirname(__DIR__, 4) . '/Domain/Constants/ProcedureNameConst.php';

class NotificationProcedure extends AbstractProcedure
{
    public static string $name = PROCEDURE_NOTIFICATION;
    private MailingService $mailingService;

    public function __construct(MailingService $mailingService)
    {
        $this->mailingService = $mailingService;
    }

    /**
     * @param NotificationRequest $request
     * @return JsonResponse
     */
    public function handle(NotificationRequest $request): JsonResponse
    {
        define('ATTRIBUTES', $request->validated());
        $service = $this->mailingService->mailInvitedOrRecord([
            FIELD_EMAIL             => ATTRIBUTES[FIELD_EMAIL],
            FIELD_INVITED_USER_ID   => ATTRIBUTES[FIELD_INVITED_USER_ID],
            FIELD_EVENT_ID          => ATTRIBUTES[FIELD_EVENT_ID],
        ]);

        return new JsonResponse(
            data:[
                FIELD_ID => self::identifier(),
                FIELD_ATTRIBUTES => $service,
                ...self::meta($request, ATTRIBUTES)
            ],
            status: Response::HTTP_CREATED
        );
    }
}
