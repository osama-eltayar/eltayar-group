<?php

namespace Database\Factories;

use App\Enums\HajClientDependencyType;
use App\Models\Client;
use App\Models\Haj;
use App\Models\HajClient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HajClient>
 */
class HajClientFactory extends Factory
{
    protected $model = HajClient::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'haj_id' => Haj::factory(),
            'booking_id' => null,
            'discount_amount' => $this->faker->randomElement([0, 0, 0, 100, 200]),
            'dependency_type' => HajClientDependencyType::Independent,
            'depends_on_haj_client_id' => null,
            'relation_type' => null,
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
