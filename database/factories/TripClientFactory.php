<?php

namespace Database\Factories;

use App\Enums\RoomType;
use App\Models\Client;
use App\Models\Trip;
use App\Models\TripClient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TripClient>
 */
class TripClientFactory extends Factory
{
    protected $model = TripClient::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'trip_id' => Trip::factory(),
            'booking_id' => null,
            'room_type' => $this->faker->randomElement(RoomType::cases()),
            'price' => $this->faker->numberBetween(1000, 6000),
            'discount_amount' => $this->faker->randomElement([0, 0, 0, 100, 200]),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
