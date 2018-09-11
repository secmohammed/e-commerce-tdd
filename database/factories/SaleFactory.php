<?php

use Faker\Generator as Faker;

$factory->define(App\Sale::class, function (Faker $faker) {
	return [
		'percentage' => 10.5,
		'user_id' => auth()->id(),
		'expires_at' => date('Y-m-d H:i:s'),
	];
});
