<?php

namespace App\Services;

use App\Models\File;
use App\Repositories\Interfaces\FileRepositoryInterface;
use Illuminate\Http\UploadedFile;

class FileService
{
    protected FileRepositoryInterface $fileRepository;

    /**
     * FileService constructor.
     *
     * @param FileRepositoryInterface $fileRepository
     */
    public function __construct(FileRepositoryInterface $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    /**
     * Handle the file upload process.
     *
     * @param UploadedFile $file
     * @param string $disk
     * @return File|null
     */
    public function handleUpload(UploadedFile $file, string $disk = 'public'): ?File
    {
        if (!$file->isValid()) {
            // TODO: Log error or throw a custom exception
            return null;
        }

        return $this->fileRepository->uploadAndCreate($file, $disk);
    }

    /**
     * Handle the file deletion process.
     *
     * @param int $fileId
     * @return bool
     */
    public function handleDelete(int $fileId): bool
    {
        return $this->fileRepository->delete($fileId);
    }

    /**
     * @param UploadedFile $file
     * @param string $folder
     *
     * @return string
     */
    public static function upload(UploadedFile $file, string $folder): string
    {
        $innerFolder = now()->format('Ym');
        if (!file_exists("upload/{$folder}/{$innerFolder}")) {
            mkdir("upload/{$folder}/{$innerFolder}", 0755, true);
        }
        $file_type = $file->getClientOriginalExtension();
        $file_code = getCode();
        $file_path = "upload/{$folder}/{$innerFolder}/{$file_code}.{$file_type}";
        $file->move("upload/{$folder}/{$innerFolder}/" , "{$file_code}.{$file_type}");
        return $file_path;
    }
}
