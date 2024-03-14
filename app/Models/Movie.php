<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;
use Staudenmeir\EloquentJsonRelations\Relations\BelongsToJson;

/**
 * @property-read int $id
 * @property int         $tmbd_id
 * @property string      $media_type
 * @property string      $title
 * @property string      $original_title
 * @property string      $original_language
 * @property string|null $backdrop_path
 * @property string|null $poster_path
 * @property array       $genre_ids
 * @property Carbon      $release_date
 * @property string      $overview
 * @property bool        $video
 * @property bool        $adult
 * @property float       $popularity
 * @property float       $vote_average
 * @property float       $vote_count
 * @property Carbon      $created_at
 * @property Carbon      $updated_at
 * @property-read string $backdrop_url
 * @property-read string $poster_url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MovieGenre> $genres
 */
class Movie extends Model
{
    use HasFactory;
    use HasJsonRelationships;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tmbd_id',
        'media_type',
        'title',
        'original_title',
        'original_language',
        'backdrop_path',
        'poster_path',
        'genre_ids',
        'release_date',
        'overview',
        'video',
        'adult',
        'popularity',
        'vote_average',
        'vote_count',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, mixed>
     */
    protected $casts = [
        'tmbd_id' => 'integer',
        'genre_ids' => 'json',
        'release_date' => 'date',
        'video' => 'boolean',
        'adult' => 'boolean',
        'popularity' => 'float',
        'vote_average' => 'float',
        'vote_count' => 'integer',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'backdrop_url',
        'poster_url',
    ];

    /**
     * Scope a query to search by a given genre.
     *
     * @param Builder $query
     * @param int     $genreId
     *
     * @return Builder
     */
    protected function scopeSearchByGenre(Builder $query, int $genreId): Builder
    {
        return $query->whereJsonContains('genre_ids', $genreId);
    }

    /**
     * Scope a query to search by a given term.
     *
     * @param Builder $query
     * @param string  $term
     *
     * @return Builder
     */
    public function scopeSearchByTerm(Builder $query, string $term): Builder
    {
        return $query->whereAny([
            'title',
            'original_title',
        ], 'LIKE', "%{$term}%");
    }

    /**
     * Get the movie's genres relationship.
     *
     * @return BelongsToJson
     */
    public function genres(): BelongsToJson
    {
        return $this->belongsToJson(MovieGenre::class, 'genre_ids', 'tmbd_id');
    }

    /**
     * Get the movie's backdrop URL.
     *
     * @return Attribute
     */
    protected function backdropUrl(): Attribute
    {
        return Attribute::make(
            get: fn (): string => static::getImageUrl($this->backdrop_path),
        );
    }

    /**
     * Get the movie's poster URL.
     *
     * @return Attribute
     */
    protected function posterUrl(): Attribute
    {
        return Attribute::make(
            get: fn (): string => static::getImageUrl($this->poster_path),
        );
    }

    /**
     * Get the image URL.
     *
     * @param ?string $path
     *
     * @return string
     */
    private static function getImageUrl(?string $path): string
    {
        return $path ? "https://image.tmdb.org/t/p/w500/{$path}" : url('assets/svg/default.svg');
    }
}
