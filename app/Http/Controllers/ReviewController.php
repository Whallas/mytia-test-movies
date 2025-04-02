<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
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

    public function destroy(Review $review)
    {
        $review->delete();

        return response()->json(['message' => 'Review deleted']);
    }
}
