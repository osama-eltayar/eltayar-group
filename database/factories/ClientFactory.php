<?php

namespace Database\Factories;

use App\Enums\ClientStatus;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name_ar' => $this->faker->name(),
            'name_en' => $this->faker->name(),
            'national_number' => $this->faker->unique()->numerify('##########'),
            'passport_number' => $this->faker->unique()->bothify('??#######'),
            'date_of_birth' => $this->faker->dateTimeBetween('-60 years', '-18 years'),
            'parent_id' => null,
            'status' => $this->faker->randomElement(ClientStatus::cases()),
        ];
    }

    public function withParent(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'parent_id' => Client::factory(),
            ];
        });
    }

    public function withChildren(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'parent_id' => null,
            ];
        });
    }
}
