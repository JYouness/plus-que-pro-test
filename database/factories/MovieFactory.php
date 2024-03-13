<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tmbd_id' => $this->faker->randomDigit(),
            'media_type' => 'movie',
            'title' => $this->faker->words(asText: true),
            'original_title' => $this->faker->words(asText: true),
            'original_language' => '',
            'backdrop_path' => null,
            'poster_path' => null,
            'genre_ids' => [],
            'release_date' => $this->faker->date(),
            'overview' => $this->faker->paragraphs(asText: true),
            'video' => $this->faker->boolean(),
            'adult' => $this->faker->boolean(),
            'popularity' => 0,
            'vote_average' => 0,
            'vote_count' => 0,
        ];
    }
}
