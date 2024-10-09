<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stuff>
 */
class StuffFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'position' => $this->faker->jobTitle(),
            'start_from' => $this->faker->date(),
            'contact_normal' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'salary_wages' => $this->faker->numberBetween(30000, 100000),
            'benifits' => $this->faker->sentence(),
            'vacation_peroid' => $this->faker->numberBetween(10, 30),
            'training_records' => $this->faker->sentence(),
            'contact_emergency' => $this->faker->phoneNumber(),
            'notes' => $this->faker->word(),

        ];
    }
}
