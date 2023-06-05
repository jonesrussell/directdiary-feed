<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
// use Spatie\Permission\Models\Role;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $adminRole = Role::findByName('admin');
        // $domainerRole = Role::findByName('domainer');
        // $freelancerRole = Role::findByName('freelancer');

        User::factory()->create([
            'firstname' => 'Direct',
            'lastname' => 'Diary',
            'username' => 'directdiary',
            'email' => 'admin@directdiary.com',
            'password' => Hash::make('direct202'),
        ]); //->assignRole($adminRole);

        User::factory()->create([
            'firstname' => 'Paul',
            'lastname'  => 'Baker',
            'username'  => 'paulbaker',
            'email'     => 'boostmyclients@gmail.com',
            'password'  => Hash::make('direct202'),
        ]); //->assignRole($adminRole);

        User::factory()->create([
            'firstname' => 'Russell',
            'lastname'  => 'Jones',
            'username'  => 'jonesrussell42',
            'email'     => 'jonesrussell42@gmail.com',
            'password'  => Hash::make('direct202'),
        ]); //->assignRole($adminRole);

        // User::factory()->afterCreating(function ($user, $faker) use ($adminRole, $domainerRole, $freelancerRole) {
        //     $roles = Role::all()->except([$adminRole->id]); // exclude the admin role
        //     $user->assignRole($roles->random());
        // })->count(7)->create();
    }
}
