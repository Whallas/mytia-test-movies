<?php

namespace Database\Factories;

use App\Models\Favorite;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavoriteFactory extends Factory
{
    protected $model = Favorite::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'movie_id' => Movie::factory(),
        ];
    }
}
