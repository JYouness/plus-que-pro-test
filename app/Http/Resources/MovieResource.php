<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Movie
 */
class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     *
     * @param Request $request
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tmbd_id' => $this->tmbd_id,
            'media_type' => $this->media_type,
            'title' => $this->title,
            'original_title' => $this->original_title,
            'original_language' => $this->original_language,
            'backdrop_path' => $this->backdrop_path,
            'poster_path' => $this->poster_path,
            'genre_ids' => $this->genre_ids,
            'genres' => MovieGenreResource::collection($this->whenLoaded('genres')),
            'release_date' => $this->release_date,
            'overview' => $this->overview,
            'video' => $this->video,
            'adult' => $this->adult,
            'popularity' => $this->popularity,
            'vote_average' => $this->vote_average,
            'vote_count' => $this->vote_count,
            'backdrop_url' => $this->backdrop_url,
            'poster_url' => $this->poster_url,
        ];
    }
}
