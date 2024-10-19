<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Create admin users
        $this->createUser([
            'firstname' => 'Direct',
            'lastname' => 'Diary',
            'username' => 'directdiary',
            'email' => 'admin@directdiary.com',
            'password' => 'direct202',
            'biography' => $faker->paragraph,
            'facebook_link' => 'https://facebook.com/' . $faker->userName,
            'twitter_link' => 'https://twitter.com/' . $faker->userName,
            'instagram_link' => 'https://instagram.com/' . $faker->userName,
            'linkedin_link' => 'https://linkedin.com/in/' . $faker->userName,
            'dns_verify_token' => Str::random(32),
        ]);

        $this->createUser([
            'firstname' => 'Paul',
            'lastname'  => 'Baker',
            'username'  => 'paulbaker',
            'email'     => 'boostmyclients@gmail.com',
            'password'  => 'direct202',
            'biography' => $faker->paragraph,
            'facebook_link' => 'https://facebook.com/' . $faker->userName,
            'twitter_link' => 'https://twitter.com/' . $faker->userName,
            'instagram_link' => 'https://instagram.com/' . $faker->userName,
            'linkedin_link' => 'https://linkedin.com/in/' . $faker->userName,
            'dns_verify_token' => Str::random(32),
        ]);

        $this->createUser([
            'firstname' => 'Russell',
            'lastname'  => 'Jones',
            'username'  => 'jonesrussell42',
            'email'     => 'jonesrussell42@gmail.com',
            'password'  => 'direct202',
            'biography' => $faker->paragraph,
            'facebook_link' => 'https://facebook.com/' . $faker->userName,
            'twitter_link' => 'https://twitter.com/' . $faker->userName,
            'instagram_link' => 'https://instagram.com/' . $faker->userName,
            'linkedin_link' => 'https://linkedin.com/in/' . $faker->userName,
            'dns_verify_token' => Str::random(32),
        ]);

        // Create additional users with unique usernames
        $additionalUsers = collect();
        $count = 7;

        while ($additionalUsers->count() < $count) {
            $user = User::factory()->make();

            // Generate a unique username
            do {
                $username = Str::lower(Str::random(8));
            } while (User::where('username', $username)->exists() || $additionalUsers->pluck('username')->contains($username));

            $user->username = $username;
            $user->biography = $faker->paragraph;
            $user->facebook_link = 'https://facebook.com/' . $faker->userName;
            $user->twitter_link = 'https://twitter.com/' . $faker->userName;
            $user->instagram_link = 'https://instagram.com/' . $faker->userName;
            $user->linkedin_link = 'https://linkedin.com/in/' . $faker->userName;
            $user->dns_verify_token = Str::random(32);

            $additionalUsers->push($user);
        }

        // Insert all additional users at once
        (new \App\Models\User)->insert($additionalUsers->map->getAttributes()->toArray());
    }

    private function createUser(array $data): void
    {
        (new \App\Models\User)->create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'biography' => $data['biography'],
            'facebook_link' => $data['facebook_link'],
            'twitter_link' => $data['twitter_link'],
            'instagram_link' => $data['instagram_link'],
            'linkedin_link' => $data['linkedin_link'],
            'dns_verify_token' => $data['dns_verify_token'],
        ]);
    }
}
