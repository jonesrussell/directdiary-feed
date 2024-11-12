<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use function Pest\Laravel\{get, post, assertAuthenticated, assertGuest};
use Illuminate\Support\Facades\RateLimiter;
use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = User::factory()->create([
        'password' => Hash::make('password'),
    ]);
});

it('renders login screen', function () {
    get('/login')->assertOk();
});

it('allows users to authenticate using the login screen', function () {
    $response = post('/login', [
        'email' => $this->user->email,
        'password' => 'password',
    ]);

    assertAuthenticated();
    $response->assertRedirect('/home');
});

it('does not authenticate users with invalid password', function () {
    post('/login', [
        'email' => $this->user->email,
        'password' => 'wrong-password',
    ]);

    assertGuest();
});

it('does not authenticate users with invalid email', function () {
    post('/login', [
        'email' => 'nonexistent@example.com',
        'password' => 'password',
    ]);

    assertGuest();
});

it('throttles login attempts', function () {
    // Clear any existing rate limiter data
    RateLimiter::clear('login');

    // Attempt to login multiple times
    foreach (range(1, 5) as $_) {
        post('/login', [
            'email' => $this->user->email,
            'password' => 'wrong-password',
        ]);
    }

    // The 6th attempt should be rate limited
    $response = post('/login', [
        'email' => $this->user->email,
        'password' => 'wrong-password',
    ]);

    // Assert that we get redirected back with throttle error
    $response->assertRedirect();
    $response->assertSessionHasErrors('email');
    
    // Get the actual error message
    $errors = session('errors')->get('email');
    expect($errors[0])->toContain('Too many login attempts');
});

it('remembers user when requested', function () {
    $response = post('/login', [
        'email' => $this->user->email,
        'password' => 'password',
        'remember' => 'on',
    ]);

    $response->assertRedirect('/home');
    assertAuthenticated();
    expect($this->user->fresh()->remember_token)->not->toBeNull();
});

it('logs out authenticated user', function () {
    actingAs($this->user)->post('/logout');

    assertGuest();
});
