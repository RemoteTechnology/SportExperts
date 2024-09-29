<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Users;

use App\Domain\Abstracts\AbstractProcedure;
use App\Http\Requests\Users\ResetRequest;
use App\Http\Resources\Users\UserResource;
use App\Jobs\MailJob;
use App\Mail\Users\ResetToPasswordMail;
use App\Repository\Filter\Entities\Users\FindByEmailRepository;
use App\Services\MailingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

require_once dirname(__DIR__, 4) . '/Domain/Constants/ProcedureNameConst.php';
require_once dirname(__DIR__, 4) . '/Domain/Constants/FieldConst.php';

class UserResetProcedure extends AbstractProcedure
{
    public static string $name = PROCEDURE_USER_RESET;
    public string $newPassword;
    private FindByEmailRepository $filter;

    public function __construct(FindByEmailRepository $filter)
    {
        $this->filter = $filter;
        $this->newPassword = Str::random(10);
    }

    /**
     * @param ResetRequest $request
     * @return JsonResponse
     */
    public function handle(ResetRequest $request): JsonResponse
    {
        define('ATTRIBUTES', $request->validated());
        $user = $this->filter->query([FIELD_EMAIL => ATTRIBUTES[FIELD_EMAIL]]);
        $user->password = Hash::make($this->newPassword);
        $user->save();

        MailJob::dispatch(ResetToPasswordMail::class, [
            FIELD_EMAIL => $user->email,
            FIELD_PASSWORD => $this->newPassword
        ]);

        return new JsonResponse(
            data: [
                FIELD_ID => self::identifier(),
                FIELD_ATTRIBUTES => new UserResource($user),
                ...self::meta($request, ATTRIBUTES)
            ],
            status: Response::HTTP_CREATED
        );
    }
}
