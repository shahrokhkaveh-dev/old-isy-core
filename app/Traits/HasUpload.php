<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;

trait HasUpload
{
    /**
     * Upload a single file and return its details.
     *
     * @param UploadedFile $file
     * @param string $disk
     * @param string $directory
     * @return array
     */
    public function uploadFile(UploadedFile $file, string $disk = 'public', string $directory = 'uploads'): array
    {
        $path = $file->store($directory, $disk);

        return [
            'disk' => $disk,
            'path' => $path,
            'filename' => $file->getClientOriginalName(),
            'extension' => $file->getClientOriginalExtension(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
        ];
    }
}
