<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category'=>$this->faker->word(),
            'amount'=>$this->faker->randomFloat(2, 10, 1000),
            'payment_method'=>$this->faker->randomElement(['credit_card', 'paypal', 'bank_transfer']),
            'vendor'=>$this->faker->company(),
            'currency'=>$this->faker->currencyCode(),
            'Description'=>$this->faker->sentence(),
            'Recipet_Attach' => $this->faker->boolean() ? 1 : 0,
        ];
    }
}
