<?php
namespace App\Services\Slider;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function processSliderImage(UploadedFile $file)
    {
        $this->validateImageFile($file);

        $filename = Str::random(40) . '.jpg';
        $path = "sliders/{$filename}";

        $image = Image::make($file)
            ->resize(1920, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode('jpg', 75);

        Storage::disk('public')->put($path, $image);

        return $path;
    }

    public function deleteImage(string $path)
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    private function validateImageFile(UploadedFile $file)
    {
        $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 2 * 1024 * 1024; // 2MB

        if (!in_array($file->getMimeType(), $allowedMimes)) {
            throw new \Exception('Invalid file type');
        }

        if ($file->getSize() > $maxSize) {
            throw new \Exception('File too large');
        }
    }
}
