<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_forgot_password_sends_email()
    {
        Notification::fake();
        $user = User::factory()->create();

        $response = $this->postJson('/api/password/forgot', ['email' => $user->email]);

        $response->assertStatus(200)->assertJson(['message' => trans(Password::RESET_LINK_SENT)]);
        Notification::assertSentTo($user, \Illuminate\Auth\Notifications\ResetPassword::class);
    }

    public function test_forgot_password_fails_for_invalid_email()
    {
        $response = $this->postJson('/api/password/forgot', ['email' => 'invalid@example.com']);
        $response->assertStatus(400);
    }

    public function test_reset_password_updates_user_password()
    {
        $user = User::factory()->create();
        $token = Password::broker()->createToken($user);

        $response = $this->postJson('/api/password/reset', [
            'email' => $user->email,
            'token' => $token,
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        $response->assertStatus(200)->assertJson(['message' => trans(Password::PASSWORD_RESET)]);
        $this->assertTrue(Hash::check('newpassword', $user->fresh()->password));
    }

    public function test_reset_password_fails_with_invalid_token()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/password/reset', [
            'email' => $user->email,
            'token' => 'invalid-token',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        $response->assertStatus(400);
    }
}
