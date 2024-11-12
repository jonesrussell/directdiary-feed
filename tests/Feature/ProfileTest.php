<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('displays profile page', function () {
    $this->actingAs($this->user)
        ->get('/profile')
        ->assertOk();
});

it('allows profile information to be updated', function ($field, $value) {
    $data = array_merge(
        $this->user->only(['firstname', 'lastname', 'email', 'username']),
        [$field => $value]
    );

    $response = $this->actingAs($this->user)
        ->patch('/profile', $data);

    $response->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    expect($this->user->refresh()->$field)->toBe($value);
})->with([
    ['firstname', 'NewFirstName'],
    ['lastname', 'NewLastName'],
    ['email', 'newemail@example.com'],
    ['username', 'newusername'],
]);

it('keeps email verification status when email is unchanged', function () {
    $this->user->email_verified_at = now();
    $this->user->save();

    $response = $this->actingAs($this->user)
        ->patch('/profile', $this->user->only(['firstname', 'lastname', 'username', 'email']));

    $response->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    expect($this->user->refresh()->email_verified_at)->not->toBeNull();
});

it('allows user to delete their account with correct password', function () {
    $this->user->password = Hash::make('password');
    $this->user->save();

    $response = $this->actingAs($this->user)
        ->delete('/profile', ['password' => 'password']);

    $response->assertSessionHasNoErrors()
        ->assertRedirect('/');

    expect(auth()->check())->toBeFalse();
    expect($this->user)->fresh()->toBeNull();
});

it('prevents account deletion with incorrect password', function () {
    $response = $this->actingAs($this->user)
        ->from('/profile')
        ->delete('/profile', ['password' => 'wrong-password']);

    $response->assertSessionHasErrors('password')
        ->assertRedirect('/profile');

    expect($this->user)->fresh()->not->toBeNull();
});
