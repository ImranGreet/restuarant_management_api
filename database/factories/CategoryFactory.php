<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories=['Electronics','Fashion','Home & Kitchen','Beauty & Health','Sports & Outdoors','Toys & Games','Books','Grocery','Automotive','Others'];
        return [
            'category' => $this->faker->randomElement($categories),
            'status' => $this->faker->boolean(),
        ];
    }
}
