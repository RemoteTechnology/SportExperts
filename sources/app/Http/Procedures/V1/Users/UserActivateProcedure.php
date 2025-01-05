<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Users;

use App\Domain\Abstracts\AbstractProcedure;
use App\Domain\Constants\EnumConstants\StatusLeadEnum;
use App\Http\Requests\Users\UserActivateRequest;
use App\Http\Resources\Users\UserResource;
use App\Repository\LeadRepository;
use App\Repository\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

require_once dirname(__DIR__, 4) . '/Domain/Constants/ProcedureNameConst.php';
require_once dirname(__DIR__, 4) . '/Domain/Constants/FieldConst.php';

class UserActivateProcedure extends AbstractProcedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = PROCEDURE_USER_ACTIVATE;

    private LeadRepository $leadRepository;
    private UserRepository $userRepository;

    public function __construct(LeadRepository $leadRepository, UserRepository $userRepository)
    {
        $this->leadRepository = $leadRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Execute the procedure.
     *
     * @param UserActivateRequest $request
     *
     * @return JsonResponse
     */
    public function handle(UserActivateRequest $request): JsonResponse
    {
        define('ATTRIBUTES', $request->validated());
        $outputMessage = ['message' => 'Ваш аккаунт активировать не удалось!', 'status' => StatusLeadEnum::NOT_PROCESSED];

        if ($this->leadRepository->updateStatus(
            ATTRIBUTES[FIELD_KEY],
            StatusLeadEnum::PROCESSED,
            Carbon::now()->timestamp
        ))
        {
            $lead = $this->leadRepository->findByKey(ATTRIBUTES[FIELD_KEY]);
            try {
                $this->userRepository->store($lead[FIELD_DATA]);
                $outputMessage = ['message' => 'Ваш аккаунт активирован!', 'status' => StatusLeadEnum::PROCESSED];
            } catch (\Exception) {
                $outputMessage['message'] = 'Ошибка активации. Аккаунт уже активирован!';
            }
        }

        return new JsonResponse(
            data: [
                FIELD_ID => self::identifier(),
                FIELD_ATTRIBUTES => $outputMessage,
                ...self::meta($request, ATTRIBUTES)
            ],
            status: Response::HTTP_CREATED
        );
    }
}
