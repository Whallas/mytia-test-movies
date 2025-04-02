<?php

namespace Database\Factories;

use App\Models\Movie;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'movie_id' => Movie::factory(),
            'rating' => $this->faker->numberBetween(1, 10),
            'comment' => $this->faker->sentence(),
        ];
    }
}
