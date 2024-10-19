<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        if (app()->environment('testing')) {
            $this->call(TestUserSeeder::class);
        } else {
            $this->call([
                UsersSeeder::class,
                PostsSeeder::class,
                ServicesTableSeeder::class,
                DomainSeeder::class,
            ]);
        }
    }
}
