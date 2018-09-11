<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

Relation::morphMap([
	'product' => App\Product::class,
	'product_type' => App\ProductVariationType::class,
	'category' => App\Category::class,
]);
class Sale extends Model {
	public function saleable() {
		return $this->morphTo();
	}
}
