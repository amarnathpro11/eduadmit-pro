<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'application_id' => \App\Models\Application::factory(),
            'transaction_id' => 'TXN' . strtoupper($this->faker->unique()->bothify('?????#####')),
            'amount' => $this->faker->randomFloat(2, 500, 5000),
            'status' => $this->faker->randomElement(['completed', 'pending', 'failed']),
            'payment_mode' => $this->faker->randomElement(['Credit Card', 'Net Banking', 'UPI', 'Debit Card']),
            'payment_date' => $this->faker->dateTimeThisYear(),
        ];
    }
}
