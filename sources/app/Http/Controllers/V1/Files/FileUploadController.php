<?php

namespace App\Http\Controllers\V1\Files;

use App\Http\Controllers\Controller;
use App\Http\Resources\FileResource;
use App\Repository\FileRepository;
use App\Services\FileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FileUploadController extends Controller
{
    protected FileService $fileService;
    protected FileRepository $fileRepository;
    public function __construct(FileService $fileService, FileRepository $fileRepository)
    {
        $this->fileService = $fileService;
        $this->fileRepository = $fileRepository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        if ($this->fileService->upload($request->file('file')))
        {
            return new JsonResponse(
                data: new FileResource(
                    $this->fileRepository->store(
                        $this->fileService->get(
                            $request->file('file')
                        )
                    )
                ),
                status: Response::HTTP_CREATED
            );
        }
        return new JsonResponse(
            data: [],
            status: Response::HTTP_CREATED
        );
    }
}
