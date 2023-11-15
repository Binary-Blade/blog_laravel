<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "full_text" => $this->full_text,
            "image" => $this->image_path,
            "tag" => new TagResource($this->whenLoaded('tags')),
            "createBy" => new UserResource($this->whenLoaded('user'))
        ];
    }
}
