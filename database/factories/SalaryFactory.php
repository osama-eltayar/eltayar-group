<?php

namespace Database\Factories;

use App\Models\Salary;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Salary>
 */
class SalaryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'amount' => $this->faker->numberBetween(3000, 15000),
            'started_at' => now(),
            'ended_at' => null,
        ];
    }

    /**
     * Indicate that the salary has ended.
     */
    public function ended(): static
    {
        return $this->state(fn (array $attributes): array => [
            'ended_at' => $this->faker->dateTimeBetween($attributes['started_at'], 'now'),
        ]);
    }
}
