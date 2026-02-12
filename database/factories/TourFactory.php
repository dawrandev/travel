<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class TourFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'price' => $this->faker->randomFloat(2, 100, 5000),
            'phone' => $this->faker->phoneNumber(),
            'rating' => $this->faker->randomFloat(1, 1, 5),
            'reviews_count' => $this->faker->numberBetween(0, 100),
            'duration_days' => $this->faker->numberBetween(1, 30),
            'duration_nights' => $this->faker->numberBetween(0, 29),
            'min_age' => $this->faker->numberBetween(0, 18),
            'max_people' => $this->faker->numberBetween(1, 50),
            'is_active' => true,
        ];
    }
}
