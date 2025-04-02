<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/reviews",
     *     summary="Add a review to a movie",
     *     tags={"Reviews"},
     *     security={{"sanctum": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"movie_id", "rating"},
     *             @OA\Property(property="movie_id", type="integer", example=1),
     *             @OA\Property(property="rating", type="integer", example=8),
     *             @OA\Property(property="comment", type="string", example="Great movie!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Review successfully created",
     *         @OA\JsonContent(type="object")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'rating' => 'required|integer|min:1|max:10',
            'comment' => 'nullable|string',
        ]);

        $review = Auth::user()->reviews()->create($data);

        return response()->json($review, 201);
    }

    /**
     * @OA\Delete(
     *     path="/api/reviews/{review}",
     *     summary="Remove a review",
     *     tags={"Reviews"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="review",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Review ID"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Review successfully removed",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Review deleted")
     *         )
     *     )
     * )
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return response()->json(['message' => 'Review deleted']);
    }
}
