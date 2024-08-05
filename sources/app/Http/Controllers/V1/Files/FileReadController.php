<?php

namespace App\Http\Controllers\V1\Files;

use App\Http\Controllers\Controller;
use App\Http\Resources\FileResource;
use App\Repository\FileRepository;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class FileReadController extends Controller
{
    protected FileRepository $fileRepository;
    public function __construct(FileRepository $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    /**
     * @param string $key
     * @return JsonResponse
     */
    public function __invoke(string $key): JsonResponse
    {
        return new JsonResponse(
            data: new FileResource(
                $this->fileRepository->getKey($key)
            ),
            status: Response::HTTP_OK
        );
    }
}
