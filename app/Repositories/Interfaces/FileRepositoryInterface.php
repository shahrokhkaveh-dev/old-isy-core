<?php

namespace App\Repositories\Interfaces;

use App\Models\File;

interface FileRepositoryInterface
{
    /**
     * Create a new file record.
     *
     * @param array $data
     * @return File
     */
    public function create(array $data): File;

    /**
     * Delete a file record and the physical file.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
