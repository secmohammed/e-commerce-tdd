<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model {
	protected $guarded = ['id'];
	protected $casts = ['details' => 'array'];
	public function type() {
		return $this->belongsTo(ProductVariationType::class, 'product_variation_type_id');
	}
	public function product() {
		return $this->belongsTo(Product::class);
	}
	public function getPriceAttribute() {
		return $this->type->price ?? $this->product->price;
	}
	public function getStockAttribute() {
		return $this->type->stock;
	}
}
