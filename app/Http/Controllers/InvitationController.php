<?php

namespace App\Http\Controllers;

use App\Actions\SendInvitationAction;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/invitations/send",
     *     summary="Send an invitation to a user",
     *     tags={"Invitations"},
     *     security={{"sanctum": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "role"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="role", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Invitation sent successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Invitation sent successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error sending the invitation"
     *     )
     * )
     */
    public function send(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:invitations,email',
            'role' => 'required|integer|in:' . implode(',', array_column(UserRole::cases(), 'value')),
        ]);

        if (User::where('email', $request->email)->exists()) {
            return response()->json(['message' => 'A user with this email already exists.'], 400);
        }

        (new SendInvitationAction())->execute($request->email, $request->role);

        return response()->json(['message' => 'Invitation sent successfully.'], 201);
    }
}
