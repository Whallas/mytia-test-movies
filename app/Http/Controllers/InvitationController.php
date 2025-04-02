<?php

namespace App\Http\Controllers;

use App\Actions\SendInvitationAction;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
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
