<?php

namespace App\Http\Controllers;

use App\Actions\UpdateUserAction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate();
        return response()->json($users);
    }

    public function update(Request $request, User $user)
    {
        if (auth()->id() === $user->id) {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $user->update(['name' => $request->name]);

            return response()->json(['message' => 'Your name has been updated successfully.', 'user' => $user]);
        }

        $this->authorize('admin');

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:8|confirmed',
            'role' => 'sometimes|integer',
            'is_active' => 'sometimes|boolean',
        ]);

        $user = (new UpdateUserAction())->execute($user, $request->all());

        return response()->json(['message' => 'User updated successfully.', 'user' => $user]);
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return response()->json(['message' => 'You cannot delete your own account.'], 403);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully.']);
    }
}
