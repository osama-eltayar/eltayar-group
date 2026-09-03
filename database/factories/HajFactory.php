<?php

namespace Database\Factories;

use App\Enums\PackageStatus;
use App\Enums\PackageType;
use App\Models\Haj;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Haj>
 */
class HajFactory extends Factory
{
    protected $model = Haj::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $depositPrice = $this->faker->numberBetween(3000, 6000);

        return [
            'name' => 'حج '.$this->faker->year(),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(PackageStatus::cases()),
            'type' => $this->faker->randomElement(PackageType::cases()),
            'deposit_price' => $depositPrice,
            'full_price' => $depositPrice + $this->faker->numberBetween(5000, 12000),
            'maximum_allowed' => $this->faker->numberBetween(10, 50),
            'passport_minimum_end_at' => $this->faker->dateTimeBetween('+7 months', '+2 years'),
        ];
    }

    public function active(): self
    {
        return $this->state(fn (array $attributes): array => [
            'status' => PackageStatus::Active,
        ]);
    }
}
