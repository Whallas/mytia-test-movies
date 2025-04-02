<?php
namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/favorites",
     *     summary="List user favorites",
     *     tags={"Favorites"},
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of user favorites",
     *         @OA\JsonContent(type="array", @OA\Items(type="object"))
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Auth::user()->favorites);
    }

    /**
     * @OA\Post(
     *     path="/api/favorites",
     *     summary="Add a movie to favorites",
     *     tags={"Favorites"},
     *     security={{"sanctum": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"movie_id", "title"},
     *             @OA\Property(property="movie_id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="Inception")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Movie added to favorites",
     *         @OA\JsonContent(type="object")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'title' => 'required|string',
        ]);

        $favorite = Auth::user()->favorites()->create($request->all());

        return response()->json($favorite, 201);
    }

    /**
     * @OA\Delete(
     *     path="/api/favorites/{id}",
     *     summary="Remove a movie from favorites",
     *     tags={"Favorites"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Favorite ID"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Favorite successfully removed",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Favorite removed")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        $favorite = Auth::user()->favorites()->findOrFail($id);
        $favorite->delete();

        return response()->json(['message' => 'Favorite removed']);
    }
}
