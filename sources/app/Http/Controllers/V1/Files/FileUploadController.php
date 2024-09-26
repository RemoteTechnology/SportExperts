<?php

namespace App\Http\Controllers\V1\Files;

use App\Http\Controllers\Controller;
use App\Http\Resources\FileResource;
use App\Repository\FileRepository;
use App\Services\FileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Js;
use Symfony\Component\HttpFoundation\Response;

require_once dirname(__DIR__, 4) . '/Domain/Constants/FieldConst.php';

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
    public function __invoke(Request $request)
    {
        $fileData = $request->file('file');
        if ($this->fileService->upload($fileData))
        {
            $service = $this->fileService->get($fileData);
            $repository = $this->fileRepository->store($service);

            return new JsonResponse(
                data: [
                    FIELD_ATTRIBUTES => new FileResource($repository)
                ],
                status: Response::HTTP_CREATED
            );
        }
        return new JsonResponse(
            data: [],
            status: Response::HTTP_CREATED
        );
    }
}
