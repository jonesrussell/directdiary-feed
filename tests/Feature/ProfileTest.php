<?php

use App\Models\User;

test('profile page is displayed', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/profile');

    $response->assertOk();
});

test('profile information can be updated', function () {
    $user = User::factory()->create();
    $newUsername = 'testuser' . time();
    $newEmail = 'test' . time() . '@example.com';

    $response = $this->actingAs($user)
        ->patch('/profile', [
            'firstname' => 'Test',
            'lastname' => 'User',
            'email' => $newEmail,
            'username' => $newUsername,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $user->refresh();

    expect($user->firstname)->toBe('Test');
    expect($user->lastname)->toBe('User');
    expect($user->email)->toBe($newEmail);
    expect($user->username)->toBe($newUsername);
});

test('email verification status is unchanged when the email address is unchanged', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->patch('/profile', [
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'username' => $user->username,
            'email' => $user->email,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    expect($user->refresh()->email_verified_at)->not->toBeNull();
});

test('user can delete their account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->delete('/profile', [
            'password' => 'password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/');

    expect(auth()->check())->toBeFalse();
    expect($user->fresh())->toBeNull();
});

test('correct password must be provided to delete account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from('/profile')
        ->delete('/profile', [
            'password' => 'wrong-password',
        ]);

    $response
        ->assertSessionHasErrors('password')
        ->assertRedirect('/profile');

    expect($user->fresh())->not->toBeNull();
});
