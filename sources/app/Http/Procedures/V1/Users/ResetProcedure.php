<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Users;

use App\Http\Requests\Users\ResetRequest;
use App\Http\Resources\Users\UserResource;
use App\Mail\Users\ResetMail;
use App\Repository\Filter\Entities\Users\FindByEmailRepository;
use App\Services\MailingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Sajya\Server\Procedure;

require_once dirname(__DIR__, 4) . '/Domain/Constants/FieldConst.php';

class ResetProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'ResetProcedure';
    public string $newPassword;
    private FindByEmailRepository $filter;
    private MailingService $mailingService;

    public function __construct(FindByEmailRepository $filter, MailingService $mailingService)
    {
        $this->filter = $filter;
        $this->mailingService = $mailingService;
        $this->newPassword = Str::random(10);
    }

    /**
     * Execute the procedure.
     *
     * @param ResetRequest $request
     *
     * @return JsonResponse
     */
    public function handle(ResetRequest $request): JsonResponse
    {
        $request->validated();
        $user = $this->filter->query([FIELD_EMAIL => $request[FIELD_EMAIL]]);
        $user->password = Hash::make($this->newPassword);
        $user->save();
        $this->mailingService->mailResetToPassword([
            FIELD_EMAIL => $user->email,
            FIELD_PASSWORD => $this->newPassword
        ]);
        return new JsonResponse(
            data: new UserResource($user),
            status: 201
        );
    }
}
