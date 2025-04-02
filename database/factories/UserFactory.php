<?php

namespace Database\Factories;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // Senha padrão
            'role' => UserRole::USER,
            'is_active' => true,
            'remember_token' => Str::random(10),
        ];
    }

    public function admin()
    {
        return $this->state(fn () => ['role' => UserRole::ADMIN]);
    }

    public function moderator()
    {
        return $this->state(fn () => ['role' => UserRole::MODERATOR]);
    }
}
