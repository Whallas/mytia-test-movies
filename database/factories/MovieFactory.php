<?php

namespace Database\Factories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    protected $model = Movie::class;

    public function definition()
    {
        return [
            'omdb_id' => $this->faker->unique()->uuid(),
            'title' => $this->faker->sentence(3),
            'year' => $this->faker->year(),
            'type' => $this->faker->randomElement(['movie', 'series']),
            'poster' => $this->faker->imageUrl(),
        ];
    }
}
