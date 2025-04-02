<?php

namespace App\Http\Controllers;

use App\Http\Actions\SearchMoviesAction;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index(Request $request, SearchMoviesAction $action)
    {
        $request->validate([
            'query' => 'required|string',
            'page' => 'nullable|integer|min:1',
        ]);

        $movies = $action->execute($request->input('query'), $request->input('page', 1));
        return response()->json($movies);
    }

    public function getReviews(Movie $movie)
    {
        return response()->json($movie->reviews);
    }
}
