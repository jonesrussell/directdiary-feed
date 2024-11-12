<?php

use App\Models\User;
use Illuminate\Support\Facades\Config;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

beforeEach(function () {
    // Mock the Config facade using Mockery
    $configMock = Mockery::mock('alias:Illuminate\Support\Facades\Config');
    $configMock->shouldReceive('get')->andReturn(null);
    
    // Mock the Media model
    $mediaMock = Mockery::mock(Media::class);
    $mediaMock->shouldReceive('getUrl')->andReturn(null);
    
    // Mock the getFirstMedia method
    User::macro('getFirstMedia', function () use ($mediaMock) {
        return $mediaMock;
    });
});

test('user full name is correct', function () {
    $user = new User([
        'firstname' => 'John',
        'lastname' => 'Doe'
    ]);
    
    expect($user->full_name)->toBe('John Doe');
});

test('user avatar url is generated correctly', function () {
    $user = new User([
        'firstname' => 'John',
        'lastname' => 'Doe'
    ]);
    
    expect($user->avatar)->toContain('https://ui-avatars.com/api/?name=John+Doe');
});
