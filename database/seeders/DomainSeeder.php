<?php

namespace Database\Seeders;

use App\Models\Domain;
use App\Models\User;
use App\Enums\DomainApproval;
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

        // Create test DDEV domains for first two users
        $testDomains = [
            // First user domains
            ['name' => 'example', 'extension' => 'ddev.site', 'user_id' => $users[0]->id],
            ['name' => 'test', 'extension' => 'ddev.site', 'user_id' => $users[0]->id],
            // Second user domains
            ['name' => 'hello', 'extension' => 'ddev.site', 'user_id' => $users[1]->id],
        ];

        foreach ($testDomains as $domain) {
            Domain::create([
                'name' => $domain['name'],
                'extension' => $domain['extension'],
                'user_id' => $domain['user_id'],
                'price' => 1000,
                'approval' => DomainApproval::Approved,
            ]);
        }

        // Create random domains for all users
        Domain::factory()
            ->count(150)
            ->make()
            ->each(function ($domain) use ($users) {
                $domain->user_id = $users->random()->id;
                $domain->save();
            });
    }
}
