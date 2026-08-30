<?php

namespace Database\Factories;

use App\Models\Borrowing;
use App\Models\BorrowingLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BorrowingLog>
 */
class BorrowingLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'borrowing_id' => Borrowing::factory(),
            'amount' => $this->faker->numberBetween(100, 1000),
            'paid_at' => now(),
        ];
    }
}
