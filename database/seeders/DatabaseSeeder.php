<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /** @var User $user */
        $user = User::where('email', 'test@example.com')->firstOrNew();

        $data = User::factory()->admin()->make([
            'name' => 'First User',
            'email' => 'test@example.com'
        ])->getAttributes();
        $user->fill($data);

        if (!$user) {
            $user->password = $data['password'];
            $user->remember_token = $data['remember_token'];
        }

        $user->save($data);
    }
}
