<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'post' => $this->faker->paragraph,
            'file' => '/videos/Sportsman.mp4',
            'is_video' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (\App\Models\Post $post) {
            $post->addMediaFromUrl('https://picsum.photos/200/300')
                 ->toMediaCollection('image');
        });
    }
}
