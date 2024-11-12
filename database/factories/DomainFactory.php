<?php

namespace Database\Factories;

use App\Models\Domain;
use App\Enums\DomainApproval;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Domain\Domain>
 */
class DomainFactory extends Factory
{
    protected $model = Domain::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->domainWord;
        $extension = fake()->randomElement(array_keys(top_level_domains()));

        // Ensure unique combination of name and extension
        while (Domain::where('name', $name)->where('extension', $extension)->exists()) {
            $name = fake()->unique()->domainWord;
            $extension = fake()->randomElement(array_keys(top_level_domains()));
        }

        return [
            'name' => $name,
            'extension' => $extension,
            'price' => fake()->numberBetween(10000, 1000000),
            'approval' => fake()->randomElement(DomainApproval::cases()),
        ];
    }
}
