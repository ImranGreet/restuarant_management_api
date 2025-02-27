<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
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
            'product_title' => $this->faker->word(),
            'category' => $this->faker->randomElement($categories),
            'price' => $this->faker->numberBetween(100, 1000),
            'status' => $this->faker->boolean(),
            'description' => $this->faker->sentence(),
            'product_image' => $this->faker->imageUrl(640, 480, 'products', true),
            'rating' => $this->faker->randomFloat(2, 1, 5), // Float between 1 and 5
            'discount' => $this->faker->numberBetween(0, 50),
        ];
    }
}
