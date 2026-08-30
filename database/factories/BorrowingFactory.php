<?php

namespace Database\Factories;

use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Borrowing>
 */
class BorrowingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $amount = $this->faker->numberBetween(1000, 10000);

        return [
            'user_id' => User::factory(),
            'amount' => $amount,
            'paid' => 0,
            'remaining' => $amount,
            'paid_at' => now(),
            'expected_at' => now()->addMonths(3),
            'ended_at' => null,
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
