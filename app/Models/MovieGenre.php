<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;
use Staudenmeir\EloquentJsonRelations\Relations\HasManyJson;

/**
 * @property-read int $id
 * @property int                        $tmbd_id
 * @property string                     $name
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Movie> $movies
 */
class MovieGenre extends Model
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
        'name',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, mixed>
     */
    protected $casts = [
        'tmbd_id' => 'integer',
    ];

    /**
     * Get the movie's genres relationship.
     *
     * @return HasManyJson
     */
    public function movies(): HasManyJson
    {
        return $this->hasManyJson(Movie::class, 'genre_ids', 'tmbd_id');
    }
}
