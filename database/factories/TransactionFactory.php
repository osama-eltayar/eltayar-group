<?php

namespace Database\Factories;

use App\Enums\Currency;
use App\Enums\PaymentMethod;
use App\Enums\TransactionType;
use App\Models\Client;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'client_id' => Client::factory(),
            'about' => fake()->sentence(4),
            'delivered_by' => fake()->name(),
            'amount' => fake()->numberBetween(100, 5000),
            'currency_code' => fake()->randomElement(Currency::cases())->value,
            'payment_method' => fake()->randomElement(PaymentMethod::cases())->value,
            'type' => fake()->randomElement(TransactionType::cases())->value,
            'notes' => fake()->optional()->sentence(),
        ];
    }

    public function reviewed(): static
    {
        return $this->state(fn (array $attributes): array => [
            'reviewed_by' => User::factory(),
        ]);
    }
}
