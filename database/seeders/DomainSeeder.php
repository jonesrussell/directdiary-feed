<?php

namespace Database\Seeders;

use App\Models\Domain;
use App\Models\User;
use Illuminate\Database\Seeder;

class DomainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->error('No users found. Please run the UsersSeeder first.');
            return;
        }

        Domain::factory()
            ->count(150)
            ->make()
            ->each(function ($domain) use ($users) {
                $domain->user_id = $users->random()->id;
                $domain->save();
            });
    }
}
