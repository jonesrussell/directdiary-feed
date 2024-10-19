<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Str;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertInertia()->component('Auth/Register');
    }

    public function test_new_users_can_register(): void
    {
        $email = 'test' . Str::random() . '@example.com';
        $username = 'testuser' . Str::random(5);

        $response = $this->post('/register', [
            'firstname' => 'Test',
            'lastname' => 'User',
            'email' => $email,
            'username' => $username,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'firstname' => 'Test',
            'lastname' => 'User',
            'email' => $email,
            'username' => $username,
        ]);
        $response->assertRedirect('https://directdiary-feed.ddev.site/home');
    }
}
