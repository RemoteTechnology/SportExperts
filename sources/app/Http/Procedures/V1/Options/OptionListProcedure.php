<?php

declare(strict_types=1);

namespace App\Http\Procedures\V1\Options;

use App\Http\Resources\Options\OptionCollection;
use App\Http\Resources\Options\OptionResource;
use App\Repository\OptionRepository;
use Illuminate\Http\JsonResponse;
use Sajya\Server\Procedure;

class OptionListProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'OptionListProcedure';

    private OptionRepository $operation;

    public function __construct(OptionRepository $operation) {
        $this->operation = $operation;
    }

    /**
     * Execute the procedure.
     *
     * @return JsonResponse
     */
    public function handle(): JsonResponse
    {
        $options = new OptionCollection($this->operation->list('paginate'));
        return new JsonResponse(
            data: $options->resource,
            status: 201
        );
    }
}
