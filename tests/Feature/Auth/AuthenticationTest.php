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
    // Configure the throttle middleware for testing
    RateLimiter::clear('login');
    
    // Attempt to login multiple times to trigger throttle
    $attempts = 6;
    $responses = [];

    for ($i = 0; $i < $attempts; $i++) {
        $response = post('/login', [
            'email' => $this->user->email,
            'password' => 'wrong-password',
        ]);
        
        $responses[] = [
            'attempt' => $i + 1,
            'status' => $response->status(),
        ];
    }

    // Check if any of the attempts resulted in a 429 status
    $throttled = collect($responses)->contains(function ($response) {
        return $response['status'] === 429;
    });

    expect($throttled)->toBeTrue('No request was throttled (status 429)');
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
