<?php

namespace Database\Factories;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Listing>
 */
class ListingFactory extends Factory
{
    protected $model = Listing::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'skill_offered' => fake()->jobTitle(),
            'skill_wanted' => fake()->jobTitle(),
            'category' => fake()->randomElement(['Programming', 'Design', 'Marketing', 'Languages']),
            'description' => fake()->sentence(),
            'status' => 'active',
        ];
    }
}
