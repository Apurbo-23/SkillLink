<?php

namespace Database\Factories;

use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Rating>
 */
class RatingFactory extends Factory
{
    protected $model = Rating::class;

    public function definition(): array
    {
        return [
            'rater_id' => User::factory(),
            'rated_user_id' => User::factory(),
            'score' => fake()->numberBetween(1, 5),
            'review' => fake()->sentence(),
        ];
    }
}
