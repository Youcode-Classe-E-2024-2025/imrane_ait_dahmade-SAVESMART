<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;

class AuthTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_user_can_view_login_form()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    public function test_user_can_view_register_form()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }

    public function test_user_can_register()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ];

        $response = $this->post('/register', $userData);

        $this->assertAuthenticated();
        $response->assertRedirect('/profile');
        $this->assertDatabaseHas('comptes', [
            'email' => 'test@example.com',
            'name' => 'Test User'
        ]);
    }

    public function test_user_cannot_register_with_invalid_email()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'invalid-email',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ];

        $response = $this->post('/register', $userData);
        $response->assertSessionHasErrors('email');
        $this->assertDatabaseMissing('comptes', ['email' => 'invalid-email']);
    }

    public function test_user_can_login()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123')
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/profile');
    }

    public function test_user_cannot_login_with_incorrect_password()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123')
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword'
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    public function test_user_can_logout()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123')
        ]);

        $this->actingAs($user);
        $this->assertAuthenticated();

        $response = $this->post('/logout');
        $this->assertGuest();
        $response->assertRedirect('/');
    }

    public function test_authenticated_user_cannot_access_login_page()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123')
        ]);

        $this->actingAs($user);
        $response = $this->get('/login');
        $response->assertRedirect('/');
    }

    public function test_user_cannot_register_with_existing_email()
    {
        $existingUser = User::create([
            'name' => 'Existing User',
            'email' => 'existing@example.com',
            'password' => Hash::make('password123')
        ]);

        $userData = [
            'name' => 'New User',
            'email' => 'existing@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ];

        $response = $this->post('/register', $userData);
        $response->assertSessionHasErrors('email');
        $this->assertDatabaseCount('comptes', 1);
    }
}
