<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
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
            'wallet_id' => Wallet::factory(),
            'type' => Transaction::TYPE_BUY,
            'amount' => $this->faker->randomFloat(2, 1, 100),
            'unit_price' => $this->faker->randomFloat(8, 1, 100),
            'total_price' => $this->faker->randomFloat(8, 1, 100),
            'date' => $this->faker->date(),
        ];
    }

    public function buy()
    {
        return $this->state(fn($attribute) => ['type' => Transaction::TYPE_BUY]);
    }

    public function sell()
    {
        return $this->state(fn($attribute) => ['type' => Transaction::TYPE_SELL]);
    }
}
