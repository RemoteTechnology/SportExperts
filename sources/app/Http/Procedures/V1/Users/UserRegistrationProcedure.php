<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Users;

use App\Domain\Abstracts\AbstractProcedure;
use App\Domain\Constants\EnumConstants\EntityLeadsEnum;
use App\Domain\Constants\EnumConstants\RoleEnum;
use App\Domain\Constants\EnumConstants\StatusLeadEnum;
use App\Http\Requests\Users\RegistrationUserRequest;
use App\Http\Resources\Users\UserResource;
use App\Jobs\MailJob;
use App\Mail\Users\RegistrationUserMail;
use App\Repository\LeadRepository;
use App\Repository\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

require_once dirname(__DIR__, 4) . '/Domain/Constants/ProcedureNameConst.php';
require_once dirname(__DIR__, 4) . '/Domain/Constants/FieldConst.php';

class UserRegistrationProcedure extends AbstractProcedure
{
    public static string $name = PROCEDURE_USER_REGISTRATION;
    private LeadRepository $leadRepository;
    private UserRepository $userRepository;

    public function __construct(LeadRepository $leadRepository, UserRepository $userRepository)
    {
        $this->leadRepository = $leadRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param RegistrationUserRequest $request
     * @return JsonResponse
     */
    public function handle(RegistrationUserRequest $request): JsonResponse
    {
        $attributes = $request->validated();
        $attributes[FIELD_PASSWORD] = Hash::make($attributes[FIELD_PASSWORD]);
        $repository = [];
        $key = Str::uuid()->toString();

        if ($attributes[FIELD_ROLE] === RoleEnum::ATHLETE && $this->leadRepository->store(
            $key,
            EntityLeadsEnum::USER_LEAD,
            StatusLeadEnum::NOT_PROCESSED,
            $attributes,
            Carbon::now()->timestamp,
        )) {
            $repository = $this->leadRepository->findByKey($key);

            MailJob::dispatch(RegistrationUserMail::class, [
                FIELD_EMAIL => $attributes[FIELD_EMAIL],
                FIELD_KEY => $key
            ]);
        } else {
            $repository = $this->userRepository->store($attributes);  // TODO: Пока ничего лучше не придумал
        }

        unset($attributes[FIELD_PASSWORD]);

        return new JsonResponse(
             data: [
                 FIELD_ID => self::identifier(),
                 FIELD_ATTRIBUTES => $repository, // TODO: возможно стоит добавить ресурс для лидов
                 ...self::meta($request, $attributes)
            ],
            status: Response::HTTP_CREATED
        );
    }
}
