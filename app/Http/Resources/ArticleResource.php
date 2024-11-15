<?php

namespace App\Http\Resources;

use App\Models\Source;
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
            'title' => $this->resource->title,
            'author' => $this->resource->author,
            'slug' => $this->resource->slug,
            'source' => Source::query()->find($this->resource->source_id)->getAttribute('slug'),
            'content' => $this->resource->content,
            'url' => $this->resource->url,
            'published_at' => $this->resource->published_at,
        ];
    }
}
