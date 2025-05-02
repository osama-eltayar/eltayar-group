<?php

namespace Database\Factories;

use App\Enums\RoomType;
use App\Enums\TripActivity;
use App\Enums\TripStatus;
use App\Enums\TripType;
use App\Models\Trip;
use App\Models\TripPrice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trip>
 */
class TripFactory extends Factory
{
    protected $model = Trip::class;

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
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'started_at' => $startDate,
            'ended_at' => $endDate,
            'status' => $this->faker->randomElement(TripStatus::cases()),
            'activity' => $this->faker->randomElement(TripActivity::cases()),
            'type' => $this->faker->randomElement(TripType::cases()),
            'maximum_allowed' => $this->faker->numberBetween(10, 50),
        ];
    }

    public function withPrices(): self
    {
        return $this->afterCreating(function (Trip $trip) {
            // Create prices for each room type
            foreach (RoomType::cases() as $roomType) {
                TripPrice::factory()->create([
                    'trip_id' => $trip->id,
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
                'status' => TripStatus::Active,
            ];
        });
    }

    public function upcoming(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'started_at' => $this->faker->dateTimeBetween('+1 month', '+6 months'),
                'ended_at' => $this->faker->dateTimeBetween('+7 months', '+1 year'),
                'status' => TripStatus::Active,
            ];
        });
    }
}
