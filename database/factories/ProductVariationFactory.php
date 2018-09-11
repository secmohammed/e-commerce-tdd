<?php

use App\Product;
use App\ProductVariation;
use Faker\Generator as Faker;

$factory->define(ProductVariation::class, function (Faker $faker) {
	return [
		'product_id' => factory(Product::class)->create()->id,
		'details' => ['color' => 'blue', 'size' => 'XL'],
	];
});
