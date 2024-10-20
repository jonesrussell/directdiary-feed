<?php

use App\Models\User;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\assertAuthenticated;
use function Pest\Laravel\assertGuest;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

test('login screen can be rendered', function () {
    $response = get('/login');

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create();

    $response = post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    assertAuthenticated();
    $response->assertRedirect('https://directdiary-feed.ddev.site/home');
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    assertGuest();
});
