<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_requires_minimum_12_char_password(): void
    {
        $response = $this->post('/inscription', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'short1234',
            'password_confirmation' => 'short1234',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_user_can_register_with_valid_data(): void
    {
        $response = $this->post('/inscription', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'SecurePassword123',
            'password_confirmation' => 'SecurePassword123',
        ]);

        $response->assertRedirect(route('account.dashboard'));
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function test_login_with_invalid_credentials_fails(): void
    {
        $response = $this->post('/connexion', [
            'email' => 'nobody@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('email');
    }
}
