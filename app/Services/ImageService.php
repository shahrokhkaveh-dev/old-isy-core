<?php

namespace App\Services;

use Carbon\Carbon;
use Spatie\Image\Image;

class ImageService
{
    static public function upload($imageUploaded)
    {
        $folder = Carbon::now()->format('Ym') . '/';
        $uploadPath = 'upload/images/' . $folder;

        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $image_type = $imageUploaded->getClientOriginalExtension();
        $image_code = getCode();
        $image_path = $uploadPath . $image_code . '.' . $image_type;

        $tmpPath = $imageUploaded->getPathname();
        $size = (int) floor($imageUploaded->getSize() / 1024);
        $info = getimagesize($tmpPath);
        $mime = $info['mime'];

        if ($size > 500) {
            $gdImage = self::createGdImageFromPath($tmpPath, $mime);
            self::saveGdImage($gdImage, $image_path, $mime, (int) floor(51200 / $size));
            imagedestroy($gdImage);
        } else {
            $imageUploaded->move($uploadPath, $image_code . '.' . $image_type);
        }

        return $image_path;
    }

    static public function setThumbnail($path, $width, $height)
    {
        $tpath = str_replace(".", "-{$width}x{$height}.", $path);
        $image = Image::load($path);
        $image->width($width);
        $image->height($height);
        $image->save($tpath);
        return $tpath;
    }

    static public function getThumbnail($path, $width, $height)
    {
        return str_replace(".", "-{$width}x{$height}.", $path);
    }

    static public function store($imageUploaded, $folder)
    {
        $innerFolder = Carbon::now()->format('Ym');
        $uploadPath = "upload/{$folder}/{$innerFolder}/";

        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $image_type = $imageUploaded->getClientOriginalExtension();
        $image_code = getCode();
        $image_path = "{$uploadPath}{$image_code}.{$image_type}";

        $tmpPath = $imageUploaded->getPathname();
        $size = (int) floor($imageUploaded->getSize() / 1024);
        $info = getimagesize($tmpPath);
        $mime = $info['mime'];

        if ($size > 500) {
            $gdImage = self::createGdImageFromPath($tmpPath, $mime);
            self::saveGdImage($gdImage, $image_path, $mime, (int) floor(51200 / $size));
            imagedestroy($gdImage);
        } else {
            $imageUploaded->move($uploadPath, "{$image_code}.{$image_type}");
        }

        return $image_path;
    }

    private static function createGdImageFromPath($path, $mime)
    {
        return match ($mime) {
            'image/jpeg' => imagecreatefromjpeg($path),
            'image/png'  => imagecreatefrompng($path),
            'image/gif'  => imagecreatefromgif($path),
            'image/webp' => imagecreatefromwebp($path),
            default => throw new \Exception("Unsupported image type: {$mime}"),
        };
    }

    private static function saveGdImage($gdImage, $path, $mime, $quality)
    {
        match ($mime) {
            'image/jpeg' => imagejpeg($gdImage, $path, $quality),
            'image/png'  => imagepng($gdImage, $path), // PNG quality is not the same scale
            'image/gif'  => imagegif($gdImage, $path),
            'image/webp' => imagewebp($gdImage, $path, $quality),
            default => throw new \Exception("Cannot save unsupported MIME type: {$mime}"),
        };
    }
}
