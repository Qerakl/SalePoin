<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

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
            'user_id' => $this->faker->numberBetween(1, 10),
            'category_id' => $this->faker->numberBetween(1, 4),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'rating' => $this->faker->numberBetween(1, 5),
            'image' =>  UploadedFile::fake()->image($this->faker->sentence())->hashName(),
            'price' => $this->faker->numberBetween(100, 3000),
            'purchase_count' => $this->faker->numberBetween(1, 10),
        ];
    }
}
