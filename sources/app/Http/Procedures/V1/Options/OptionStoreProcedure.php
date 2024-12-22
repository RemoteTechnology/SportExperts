<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Options;

use App\Domain\Abstracts\AbstractProcedure;
use App\Domain\Constants\EnumConstants\EntityLeadsEnum;
use App\Domain\Constants\EnumConstants\StatusLeadEnum;
use App\Http\Requests\Options\StoreOptionRequest;
use App\Repository\LeadRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

require_once dirname(__DIR__, 4) . '/Domain/Constants/ProcedureNameConst.php';

class OptionStoreProcedure extends AbstractProcedure
{
    public static string $name = PROCEDURE_OPTION_STORE;
    private LeadRepository $leadRepository;

    public function __construct(LeadRepository $leadRepository) {
        $this->leadRepository = $leadRepository;
    }

    /**
     * @param StoreOptionRequest $request
     * @return JsonResponse
     */
    public function handle(StoreOptionRequest $request)
    {
        $repository = [];
        define('ATTRIBUTES', $request->validated());
        $key = Str::uuid()->toString();

        if ($this->leadRepository->store(
            $key,
            EntityLeadsEnum::OPTION_LEAD,
            StatusLeadEnum::NOT_PROCESSED,
            ATTRIBUTES,
            Carbon::now()->timestamp,
        ))
        {
            $repository = $this->leadRepository->findByKey($key);
        }

        return new JsonResponse(
            data: [
                FIELD_ID => self::identifier(),
                FIELD_ATTRIBUTES => $repository, // TODO: возможно стоит добавить ресурс для лидов | new OptionResource($repository),
                ...self::meta($request, ATTRIBUTES)
            ],
            status: Response::HTTP_CREATED
        );
    }
}
