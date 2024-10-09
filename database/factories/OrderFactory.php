<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_no' => $this->faker->unique()->regexify('ORD-[0-9]{5}'),
            'order_items' => json_encode([
                [
                    'item_name' => $this->faker->word(),
                    'quantity' => $this->faker->numberBetween(1, 10),
                    'price' => $this->faker->numberBetween(10, 100),
                ],

            ]),
            'order_type' => $this->faker->randomElement(['delivery', 'pickup']),
            'payment_method' => $this->faker->randomElement(['credit_card', 'paypal', 'cash']),
            'status' => $this->faker->randomElement(['pending', 'completed', 'cancelled']),
            'time_placed' => $this->faker->dateTimeBetween('-1 months', 'now'),
        ];
    }
}
