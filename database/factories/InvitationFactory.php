<?php

namespace Database\Factories;

use App\Models\Invitation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class InvitationFactory extends Factory
{
    protected $model = Invitation::class;

    public function definition()
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'token' => Str::random(32),
            'role' => rand(1, 3), // Valores de UserRole
            'expires_at' => now()->addHours(48),
        ];
    }
}
