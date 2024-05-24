<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            'key' => Str::uuid()->toString(),
            'name' => $file->getFilename(),
            'mime' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'extension' => $file->getExtension(),
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
