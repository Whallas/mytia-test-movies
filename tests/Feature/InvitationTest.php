<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvitationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_send_invitation()
    {
        $admin = User::factory()->create(['role' => UserRole::ADMIN]);

        $response = $this->actingAs($admin)->postJson('/api/invitations/send', [
            'email' => 'test@example.com',
            'role' => UserRole::USER,
        ]);

        $response->assertStatus(201)->assertJson(['message' => 'Invitation sent successfully.']);
    }

    public function test_non_admin_cannot_send_invitation()
    {
        $user = User::factory()->create(['role' => UserRole::USER]);

        $response = $this->actingAs($user)->postJson('/api/invitations/send', [
            'email' => 'test@example.com',
            'role' => UserRole::USER,
        ]);

        $response->assertStatus(403);
    }

    public function test_cannot_send_invitation_to_existing_email()
    {
        $admin = User::factory()->create(['role' => UserRole::ADMIN]);
        $existingUser = User::factory()->create(['email' => 'test@example.com']);

        $response = $this->actingAs($admin)->postJson('/api/invitations/send', [
            'email' => $existingUser->email,
            'role' => UserRole::USER,
        ]);

        $response->assertStatus(400)->assertJson(['message' => 'A user with this email already exists.']);
    }
}
