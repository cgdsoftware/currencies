<?php

use Faker\Generator as Faker;
use LaravelEnso\Currencies\app\Models\Currency;
use LaravelEnso\Currencies\app\Models\ExchangeRate;

$factory->define(ExchangeRate::class, fn(Faker $faker) => [
    'from_id' => fn() => factory(Currency::class)->create()->id,
    'to_id' => fn() => factory(Currency::class)->create()->id,
    'conversion' => $faker->randomFloat(4, 0.0001, 10.0000),
    'date' => now()->subDays(rand(15, 40)),
]);
