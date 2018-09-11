<?php

namespace App;

use App\Contracts\CartInterface;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model implements CartInterface {

	protected $guarded = [];
	public function user() {
		return $this->belongsToMany(User::class, 'cart_user');
	}
	public function product() {
		return $this->belongsTo(Product::class)->where('reviewed', true);
	}
	public function type() {
		return $this->belongsTo(ProductVariationType::class, 'product_variation_type_id');
	}
}
