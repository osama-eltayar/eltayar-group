<?php

namespace Database\Factories;

use App\Enums\PackageStatus;
use App\Enums\PackageType;
use App\Enums\RoomType;
use App\Models\Omra;
use App\Models\OmraPrice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Omra>
 */
class OmraFactory extends Factory
{
    protected $model = Omra::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('now', '+2 months');
        $endDate = $this->faker->dateTimeBetween($startDate, '+1 year');

        return [
            'name' => Omra::generateHijriName($startDate),
            'description' => $this->faker->paragraph(),
            'started_at' => $startDate,
            'ended_at' => $endDate,
            'status' => $this->faker->randomElement(PackageStatus::cases()),
            'type' => $this->faker->randomElement(PackageType::cases()),
            'maximum_allowed' => $this->faker->numberBetween(10, 50),
        ];
    }

    public function withPrices(): self
    {
        return $this->afterCreating(function (Omra $omra) {
            // Create prices for each room type
            foreach (RoomType::cases() as $roomType) {
                OmraPrice::factory()->create([
                    'omra_id' => $omra->id,
                    'room_type' => $roomType,
                    'price' => $this->faker->numberBetween(1000, 5000),
                    'is_active' => true,
                ]);
            }
        });
    }

    public function active(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => PackageStatus::Active,
            ];
        });
    }

    public function upcoming(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'started_at' => $this->faker->dateTimeBetween('+1 month', '+6 months'),
                'ended_at' => $this->faker->dateTimeBetween('+7 months', '+1 year'),
                'status' => PackageStatus::Active,
            ];
        });
    }
}
