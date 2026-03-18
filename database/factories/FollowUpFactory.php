<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FollowUp>
 */
class FollowUpFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'lead_id' => \App\Models\Lead::factory(),
            'user_id' => 1, // Assume admin user has ID 1
            'scheduled_at' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'status' => 'scheduled',
            'note' => $this->faker->sentence(),
            'system_notification' => true,
            'email_notification' => false,
        ];
    }
}
