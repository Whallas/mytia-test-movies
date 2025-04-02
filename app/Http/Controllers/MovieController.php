<?php

namespace App\Http\Controllers;

use App\Http\Actions\SearchMoviesAction;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/movies",
     *     summary="Search movies",
     *     tags={"Movies"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="query",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="Search term for movies"
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer", minimum=1),
     *         description="Page number for pagination"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of movies found",
     *         @OA\JsonContent(type="array", @OA\Items(type="object"))
     *     )
     * )
     */
    public function index(Request $request, SearchMoviesAction $action)
    {
        $request->validate([
            'query' => 'required|string',
            'page' => 'nullable|integer|min:1',
        ]);

        $movies = $action->execute($request->input('query'), $request->input('page', 1));
        return response()->json($movies);
    }

    /**
     * @OA\Get(
     *     path="/api/movies/{movie}/reviews",
     *     summary="List reviews for a movie",
     *     tags={"Movies"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="movie",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Movie ID"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of reviews for the movie",
     *         @OA\JsonContent(type="array", @OA\Items(type="object"))
     *     )
     * )
     */
    public function getReviews(Movie $movie)
    {
        return response()->json($movie->reviews);
    }
}
