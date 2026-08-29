<?php

namespace Database\Factories;

use App\Enums\ClientServiceStatus;
use App\Models\Client;
use App\Models\ClientService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ClientService>
 */
class ClientServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'service_name' => $this->faker->randomElement([
                'تأشيرة',
                'تذكرة طيران',
                'تأمين سفر',
                'حجز فندق',
                'نقل من وإلى المطار',
            ]),
            'service_date' => $this->faker->dateTimeBetween('-1 month', '+2 months'),
            'amount' => $this->faker->numberBetween(200, 3000),
            'status' => $this->faker->randomElement(ClientServiceStatus::cases()),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
