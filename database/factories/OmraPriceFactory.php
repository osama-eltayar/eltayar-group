<?php

namespace Database\Factories;

use App\Enums\RoomType;
use App\Models\Omra;
use App\Models\OmraPrice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OmraPrice>
 */
class OmraPriceFactory extends Factory
{
    protected $model = OmraPrice::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'omra_id' => Omra::factory(),
            'room_type' => $this->faker->randomElement(RoomType::cases()),
            'price' => $this->faker->numberBetween(1000, 6000),
            'is_active' => true,
        ];
    }
}
