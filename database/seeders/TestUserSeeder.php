<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create([
            'firstname' => 'Test',
            'lastname' => 'User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'biography' => 'This is a test user biography.',
            'facebook_link' => 'https://facebook.com/testuser',
            'twitter_link' => 'https://twitter.com/testuser',
            'instagram_link' => 'https://instagram.com/testuser',
            'linkedin_link' => 'https://linkedin.com/in/testuser',
        ]);

        // Create a test post for the user
        Post::factory()->create([
            'user_id' => $user->id,
        ]);

        // Add more test users if needed
    }
}
