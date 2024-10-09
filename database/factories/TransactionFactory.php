<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Transaction_Id' => $this->faker->uuid(), // Generates a random UUID
            'payment_method' => $this->faker->randomElement(['credit_card', 'paypal', 'bank_transfer']),
            'order_srial_no' => $this->faker->regexify('[A-Z0-9]{10}'), // Generates a random serial number
            'amount' => $this->faker->numberBetween(100, 1000),
        ];
    }
}
