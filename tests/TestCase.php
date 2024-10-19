<?php

namespace Tests;

use Database\Seeders\TestUserSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        // Run migrations for the testing database
        Artisan::call('migrate:fresh');

        // Seed the database with test data
        $this->seed(TestUserSeeder::class);
    }
}
