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
        $services = [
            [
                'name' => 'Web Development',
                'key' => 'web-development',
                'description' => 'Web Development Services',
            ],
            [
                'name' => 'Domaining',
                'key' => 'domaining',
                'description' => 'Domaining Services',
            ],
            [
                'name' => 'Web Design',
                'key' => 'web-design',
                'description' => 'Web Design Services',
            ],
            [
                'name' => 'Modeling',
                'key' => 'modeling',
                'description' => 'Modeling Services',
            ],
            [
                'name' => 'Photography',
                'key' => 'photography',
                'description' => 'Photography services',
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
