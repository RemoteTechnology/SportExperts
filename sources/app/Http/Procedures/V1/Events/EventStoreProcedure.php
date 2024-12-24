<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Events;

use App\Domain\Abstracts\AbstractProcedure;
use App\Domain\Constants\EnumConstants\EntityLeadsEnum;
use App\Domain\Constants\EnumConstants\StatusLeadEnum;
use App\Http\Requests\Events\StoreEventRequest;
use App\Repository\LeadRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

require_once dirname(__DIR__, 4) . '/Domain/Constants/EventStatusesConst.php';
require_once dirname(__DIR__, 4) . '/Domain/Constants/ProcedureNameConst.php';
require_once dirname(__DIR__, 4) . '/Domain/Constants/FieldConst.php';

class EventStoreProcedure extends AbstractProcedure
{
    public static string $name = PROCEDURE_EVENT_STORE;
    private LeadRepository $leadRepository;

    public function __construct(LeadRepository $leadRepository)
    {
        $this->leadRepository = $leadRepository;
    }

    /**
     * @param StoreEventRequest $request
     * @return JsonResponse
     */
    public function handle(StoreEventRequest $request): JsonResponse
    {
        $repository = [];
        $attributes = $request->validated();
        $attributes[FIELD_STATUS] = EVENT_ACTIVE;
        $attributes[FIELD_KEY] = Str::uuid()->toString();
        $key = Str::uuid()->toString();

        if ($this->leadRepository->store(
            $key,
            EntityLeadsEnum::EVENT_LEAD,
            StatusLeadEnum::NOT_PROCESSED,
            $attributes,
            Carbon::now()->timestamp,
        ))
        {
            $repository = $this->leadRepository->findByKey($key);
        }

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
