<?php

namespace Database\Factories;

use App\Models\User;
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
        $name = $this->faker->unique()->domainWord;
        $extension = $this->faker->randomElement(['com', 'net', 'org', 'io', 'co', 'app']);

        // Ensure unique combination of name and extension
        while (Domain::where('name', $name)->where('extension', $extension)->exists()) {
            $name = $this->faker->unique()->domainWord;
        }

        return [
            'user_id' => User::factory(),
            'name' => $name,
            'extension' => $extension,
            'price' => $this->faker->numberBetween(10000, 1000000),
            'approval' => $this->faker->randomElement(DomainApproval::cases()),
        ];
    }
}
