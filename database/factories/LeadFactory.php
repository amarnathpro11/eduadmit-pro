<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Course;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lead>
 */
class LeadFactory extends Factory
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
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'source' => $this->faker->randomElement(['Website', 'Social Media', 'Referrals', 'Ads']),
            'course_id' => Course::first()->id ?? 1,
            'assigned_to' => User::first()->id ?? 1,
            'status' => 'Pending',
            'score' => $this->faker->numberBetween(0, 100)
        ];
    }
}
