<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Teams;

use App\Domain\Abstracts\AbstractProcedure;
use App\Http\Resources\Teams\TeamCollection;
use App\Http\Resources\Teams\TeamResource;
use App\Models\Team;
use App\Repository\TeamRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Sajya\Server\Procedure;

require_once dirname(__DIR__, 4) . '/Domain/Constants/ProcedureNameConst.php';
require_once dirname(__DIR__, 4) . '/Domain/Constants/FieldConst.php';

class TeamListProcedure extends AbstractProcedure
{
    public static string $name = PROCEDURE_TEAM_LIST;
    private TeamRepository $teamRepository;

    public function __construct(TeamRepository $teamRepository) {
        $this->teamRepository = $teamRepository;
    }

    /**
     * @return JsonResponse
     */
    public function handle(Request $request): JsonResponse
    {
        $repository = $this->teamRepository->list(FIELD_PAGINATE);
        $collectData = new TeamCollection($repository);

        return new JsonResponse(
            data: [
                FIELD_ID => self::identifier(),
                FIELD_ATTRIBUTES => $collectData->resource,
                ...self::meta($request, [])
            ],
            status: Response::HTTP_CREATED
        );
    }
}
