<?php

namespace App\Http\Controllers\V1\Files;

use App\Http\Controllers\Controller;
use App\Http\Resources\FileResource;
use App\Repository\FileRepository;
use App\Services\FileService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class FileDestroyController extends Controller
{
    protected FileService $fileService;
    protected FileRepository $fileRepository;
    public function __construct(FileService $fileService, FileRepository $fileRepository)
    {
        $this->fileService = $fileService;
        $this->fileRepository = $fileRepository;
    }

    /**
     * @param string $key
     * @return JsonResponse
     */
    public function __invoke(string $key): JsonResponse
    {
        $file = $this->fileRepository->getKey($key);
        if ($this->fileService->delete($file->name))
        {
            return new JsonResponse(
                data: new FileResource(
                    $this->fileRepository->destroy($file)
                ),
                status: Response::HTTP_OK
            );
        }
        return new JsonResponse(
            data: [],
            status: Response::HTTP_OK
        );
    }
}
