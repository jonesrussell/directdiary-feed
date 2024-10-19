<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create predefined services
        $predefinedServices = [
            ['name' => 'Web Development', 'key' => 'web-development'],
            ['name' => 'Domaining', 'key' => 'domaining'],
            ['name' => 'Web Design', 'key' => 'web-design'],
            ['name' => 'Modeling', 'key' => 'modeling'],
            ['name' => 'Photography', 'key' => 'photography'],
        ];

        foreach ($predefinedServices as $service) {
            Service::factory()->create([
                'name' => $service['name'],
                'key' => $service['key'],
                'description' => $service['name'] . ' Services',
            ]);
        }

        // Create additional random services
        Service::factory()->count(5)->create();
    }
}
