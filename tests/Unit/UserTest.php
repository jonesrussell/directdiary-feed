<?php

use App\Models\User;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

test('user full name is correct', function () {
    $user = User::factory()->make([
        'firstname' => 'John',
        'lastname' => 'Doe'
    ]);
    
    expect($user->fullName)->toBe('John Doe');
});

test('user avatar url is generated correctly', function () {
    $user = User::factory()->make([
        'firstname' => 'John',
        'lastname' => 'Doe'
    ]);
    
    expect($user->avatar)->toContain('https://ui-avatars.com/api/?name=John+Doe');
});
