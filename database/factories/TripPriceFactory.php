<?php

namespace Database\Factories;

use App\Enums\RoomType;
use App\Models\Trip;
use App\Models\TripPrice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TripPrice>
 */
class TripPriceFactory extends Factory
{
    protected $model = TripPrice::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'trip_id' => Trip::factory(),
            'room_type' => $this->faker->randomElement(RoomType::cases()),
            'price' => $this->faker->numberBetween(1000, 6000),
            'is_active' => true,
        ];
    }
}
