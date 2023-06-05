<?php

namespace Database\Factories\Domain;

use App\Enums\DomainApproval;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
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
            'image' => 'https://randomuser.me/api/portraits/men/40.jpg',
            'post' => "We went rock climbing this weekend? Here is the video. Climbing is way more fun than exercising on any gym equipment. It works both your mind and body. Best of all it trains you to be creative and think out of the box. It's also an ongoing competition with yourself as you aim to improve your performance. ENJOY!",
            'file' => '/videos/Sportsman.mp4',
            'is_video' => true,
            'comments' => '35',
            'reposts' => '54',
            'likes' => '88',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }
}
