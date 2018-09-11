<?php

use App\ProductVariationType;
use Faker\Generator as Faker;

$factory->define(ProductVariationType::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->name,
        'stock' => $faker->numberBetween(3,50)

    ];
});
