<?php

namespace App\Actions;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterUserAction
{
    public function execute(string $name, string $password, Invitation $invitation): User
    {
        return User::create([
            'name' => $name,
            'email' => $invitation->email,
            'password' => Hash::make($password),
            'role' => $invitation->role,
            'is_active' => true,
        ]);
    }
}
