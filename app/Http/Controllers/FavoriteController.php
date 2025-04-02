<?php
namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        return response()->json(Auth::user()->favorites);
    }

    public function store(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'title' => 'required|string',
        ]);

        $favorite = Auth::user()->favorites()->create($request->all());

        return response()->json($favorite, 201);
    }

    public function destroy($id)
    {
        $favorite = Auth::user()->favorites()->findOrFail($id);
        $favorite->delete();

        return response()->json(['message' => 'Favorite removed']);
    }
}
