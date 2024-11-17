<?php

use App\Models\User;
use App\Models\Domain;
use App\Enums\DomainApproval;

beforeEach(function () {
    $this->user = User::factory()->create([
        'username' => 'testuser',
    ]);

    $this->domain = Domain::factory()->create([
        'user_id' => $this->user->id,
        'name' => 'example',
        'extension' => 'com',
        'approval' => DomainApproval::Approved,
    ]);
});

test('custom domain redirects to user profile', function () {
    // Mock the request host
    $this->get('/')
        ->withHost('example.com')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('PublicProfile')
            ->has('profile', fn ($profile) => $profile
                ->where('username', 'testuser')
                ->etc()
            )
            ->where('view', 'posts')
            ->where('isCustomDomain', true)
        );
});

test('unapproved domain returns 404', function () {
    $this->domain->update(['approval' => DomainApproval::New]);

    $this->get('/')
        ->withHost('example.com')
        ->assertNotFound();
});

test('non-existent domain returns 404', function () {
    $this->get('/')
        ->withHost('nonexistent.com')
        ->assertNotFound();
});

test('main app domain shows normal profile page', function () {
    config(['app.url' => 'foo.com']);

    $this->get('/testuser')
        ->withHost('foo.com')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('PublicProfile')
            ->has('profile', fn ($profile) => $profile
                ->where('username', 'testuser')
                ->etc()
            )
            ->where('view', 'posts')
            ->where('isCustomDomain', false)
        );
});

test('custom domain shows posts view by default', function () {
    $this->get('/')
        ->withHost('example.com')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->where('view', 'posts')
        );
});

test('custom domain can access domains view', function () {
    $this->get('/domains')
        ->withHost('example.com')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->where('view', 'domains')
        );
});

test('www subdomain works same as apex domain', function () {
    $this->get('/')
        ->withHost('www.example.com')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('PublicProfile')
            ->has('profile', fn ($profile) => $profile
                ->where('username', 'testuser')
                ->etc()
            )
        );
});