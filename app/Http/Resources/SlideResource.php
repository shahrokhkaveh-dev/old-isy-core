<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SlideResource extends JsonResource
{
    public static $wrap = null;
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->translation->title,
            'title_position' => $this->title_position,
            'text' => $this->translation->text,
            'text_position' => $this->text_position,
            'file' => FileResource::make($this->whenLoaded('file')),
        ];
    }
}
