<?php

namespace LaravelEnso\Currencies\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LaravelEnso\Currencies\Models\Currency;
use LaravelEnso\Currencies\Models\ExchangeRate;

class ExchangeRateFactory extends Factory
{
    protected $model = ExchangeRate::class;

    public function definition()
    {
        return [
            'from_id' => fn () => Currency::factory(),
            'to_id' => fn () => Currency::factory(),
            'conversion' => $this->faker->randomFloat(4, 0.0001, 10.0000),
            'date' => now()->subDays(rand(15, 40)),
        ];
    }
}
