<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductVariationType extends Model {
	protected $guarded = ['id'];
	public function product() {
		return $this->belongsTo(Product::class);
	}
	public function sales() {
		return $this->morphMany(Sale::class, 'saleable');
	}

	public function variations() {
		return $this->hasMany(ProductVariation::class);
	}
}
