<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stock>
 */
class StockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'product_title'=>$this->faker->word(),
        'category'=>$this->faker->word(),
        'reordr_point'=>$this->faker->numberBetween(10, 100),
        'quantity_in_hand'=>$this->faker->numberBetween(10, 100),
        'minimum_quantity_in_hand'=>$this->faker->numberBetween(20, 100),
        'leadtime'=>$this->faker->numberBetween(10, 100),
        'preferred_supplier'=>$this->faker->word(),
        'ingredient_use'=>$this->faker->randomFloat(0, 1),
        'expiration_date'=> $this->faker->dateTime(),
        'location'=>$this->faker->latitude(),
        'notes'=>$this->faker->word()
        ];
    }
}
