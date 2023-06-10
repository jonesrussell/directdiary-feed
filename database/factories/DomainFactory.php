<?php

namespace Database\Factories;

use App\Enums\DomainApproval;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Domain\Domain>
 */
class DomainFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->randomDigit() + 1,
            'name' => fake()->domainWord(),
            'extension' => fake()->randomElement(array_keys(top_level_domains())),
            'price' => fake()->numberBetween(1000, 999999),
            'approval' => fake()->randomElement([
                DomainApproval::Approved,
                DomainApproval::Denied,
                DomainApproval::New,
            ]),
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ];
    }
}
