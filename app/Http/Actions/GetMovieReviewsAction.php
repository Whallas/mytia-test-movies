<?php

namespace App\Http\Actions;

use App\Models\Movie;

class GetMovieReviewsAction
{
    public function execute(Movie $movie)
    {
        return $movie->reviews;
    }
}
