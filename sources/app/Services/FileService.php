<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

require_once dirname(__DIR__) . '/Domain/Constants/FieldConst.php';

class FileService
{
    /**
     * @param UploadedFile $file
     * @return false|string
     */
    public function upload(UploadedFile $file): false|string
    {
        return $file->store('uploads', 'public');
    }

    /**
     * @param UploadedFile $file
     * @return array
     */
    public function get(UploadedFile $file): array
    {
        return [
            FIELD_KEY       => Str::uuid()->toString(),
            FIELD_NAME      => $file->hashName(),
            FIELD_MIME      => $file->getClientMimeType(),
            FIELD_SIZE      => $file->getSize(),
            FIELD_EXTENSION => $file->getExtension(),
        ];
    }

    /**
     * @param string $name
     * @return bool
     */
    public function delete(string $name): bool
    {
        $disk = new Storage();
        return $disk::delete($name);
    }
}
