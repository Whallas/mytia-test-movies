<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserActiveMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_inactive_user_cannot_access_protected_routes()
    {
        $user = User::factory()->create(['is_active' => false]);

        $response = $this->actingAs($user)->getJson('/api/favorites');
        $response->assertStatus(403)->assertJson(['error' => 'Your account is inactive.']);
    }

    public function test_active_user_can_access_protected_routes()
    {
        $user = User::factory()->create(['is_active' => true]);

        $response = $this->actingAs($user)->getJson('/api/favorites');
        $response->assertStatus(200);
    }

    public function test_guest_user_cannot_access_protected_routes()
    {
        $response = $this->getJson('/api/favorites');
        $response->assertStatus(401);
    }
}
