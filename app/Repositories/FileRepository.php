<?php

namespace App\Repositories;

use App\Models\File;
use App\Repositories\Interfaces\FileRepositoryInterface;
use App\Traits\HasUpload;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileRepository implements FileRepositoryInterface
{
    use HasUpload;

    protected File $model;

    /**
     * FileRepository constructor.
     *
     * @param File $file
     */
    public function __construct(File $file)
    {
        $this->model = $file;
    }

    public function create(array $data): File
    {
        return $this->model->create($data);
    }

    public function delete(int $id): bool
    {
        $file = $this->model->find($id);
        if (!$file) {
            return false;
        }

        // Delete the physical file from the disk
        Storage::disk($file->disk)->delete($file->path);

        // Delete the file record from the database
        return $file->delete();
    }

    /**
     * Uploads a file and creates a record in the database.
     *
     * @param UploadedFile $file
     * @param string $disk
     * @return File
     */
    public function uploadAndCreate(UploadedFile $file, string $disk = 'public'): File
    {
        $fileData = $this->uploadFile($file, $disk);
        return $this->create($fileData);
    }
}
