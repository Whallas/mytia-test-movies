<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateUserAction
{
    public function execute(User $user, array $data): User
    {
        $updateData = array_filter($data, fn($key) => in_array($key, ['name', 'email', 'role', 'is_active']), ARRAY_FILTER_USE_KEY);

        if (!empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $user->update($updateData);

        return $user;
    }
}
