<?php

namespace Database\Factories;

use App\Models\Salary;
use App\Models\SalaryLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SalaryLog>
 */
class SalaryLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $forMonth = $this->faker->dateTimeBetween('-6 months', 'now')->modify('first day of this month');

        return [
            'salary_id' => Salary::factory(),
            'amount' => $this->faker->numberBetween(3000, 15000),
            'paid_at' => $forMonth,
            'for_month' => $forMonth,
        ];
    }
}
