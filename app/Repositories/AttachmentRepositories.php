<?php
namespace App\Repositories;

use Illuminate\Support\Facades\Storage;

class AttachmentRepositories
{
    static public function put($file)
    {
        $path = Storage::disk('local')->putFile('/attachments', $file);
        return $path;
    }
}
