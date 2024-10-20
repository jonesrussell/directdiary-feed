<?php

use Illuminate\Support\Str;
use Inertia\Testing\AssertableInertia as Assert;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
    $response->assertInertia(fn (Assert $page) => $page
        ->component('Auth/Register')
    );
});

test('new users can register', function () {
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
    $response->assertRedirect('/home');
});
