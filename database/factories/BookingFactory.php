<?php

namespace Database\Factories;

use App\Enums\RoomType;
use App\Models\Booking;
use App\Models\Branch;
use App\Models\Client;
use App\Models\Omra;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    protected $model = Booking::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'branch_id' => Branch::factory(),
            'bookable_type' => Omra::class,
            'bookable_id' => Omra::factory(),
            'room_type' => $this->faker->randomElement(RoomType::cases()),
            'price' => $this->faker->numberBetween(1000, 6000),
            'number_of_clients' => $this->faker->numberBetween(1, 4),
            'discount_amount' => $this->faker->randomElement([0, 0, 0, 100, 200]),
            'paid' => 0,
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
