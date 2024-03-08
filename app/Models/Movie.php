<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 * @property int $tmbd_id
 * @property string $media_type
 * @property string $title
 * @property string $original_title
 * @property string $original_language
 * @property string|null $backdrop_path
 * @property string|null $poster_path
 * @property array $genre_ids
 * @property Carbon $release_date
 * @property string $overview
 * @property bool $video
 * @property bool $adult
 * @property float $popularity
 * @property float $vote_average
 * @property float $vote_count
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read string $backdrop_url
 * @property-read string $poster_url
 */
class Movie extends Model
{
    use HasFactory;

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
     * @var array
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

    protected $appends = [
        'backdrop_url',
        'poster_url',
    ];

    /**
     * Get the movie's backdrop URL.
     */
    protected function backdropUrl(): Attribute
    {
        return Attribute::make(
            get: fn (): string => static::getImageUrl($this->backdrop_path),
        );
    }

    /**
     * Get the movie's poster URL.
     */
    protected function posterUrl(): Attribute
    {
        return Attribute::make(
            get: fn (): string => static::getImageUrl($this->poster_path),
        );
    }

    private static function getImageUrl(?string $path): string
    {
        return $path ? "https://image.tmdb.org/t/p/w500/{$path}" : url('assets/svg/default.svg');
    }
}
