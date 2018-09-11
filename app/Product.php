<?php

namespace App;

use App\Contracts\ProductInterface;
use App\Repositories\Traits\HasSale;
use Illuminate\Database\Eloquent\Model;

class Product extends Model implements ProductInterface {
	use HasSale;
	protected $guarded = ['id'];
	protected $sale = 0;
	public function carts() {
		return $this->hasMany(Cart::class);
	}
	public function sales() {
		return $this->morphMany(Sale::class, 'saleable')->whereActive(true);
	}
	public function wishlists() {
		return $this->hasMany(Product::class);
	}
	public function owner() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}
	public function shouldBeReviewed() {
		return !!config('product.review');
	}
	public function categories() {
		return $this->belongsToMany(Category::class);
	}
	public function variations() {
		return $this->hasMany(ProductVariation::class)->orderBy('order', 'asc');
	}
	public function types() {
		return $this->hasMany(ProductVariationType::class);
	}
	public function categoriesDiscount() {
		return collect(\DB::select('select sales.*, category_product.category_id from sales inner join category_product on category_product.category_id = sales.saleable_id AND sales.saleable_type=\'App\Category\' where category_product.product_id = ' . $this->id));
	}
	public function typesDiscount() {
		return collect(\DB::select('select sales.saleable_id,sales.saleable_type,sales.percentage, product_variation_types.id from sales inner join product_variation_types on product_variation_types.id = sales.saleable_id  AND sales.saleable_type=\'App\ProductVariationType\' where product_variation_types.product_id = ' . $this->id));
	}
	public function discounts() {
		if (!$this->sale) {
			$this->sale = $this->categoriesDiscount()->sum('percentage') + $this->typesDiscount()->sum('percentage') + ($this->sales()->latest()->first()->percentage ?? 0);
		}
		return $this->sale;
	}
	public function getHasSaleAttribute() {
		return $this->discounts() > 0;
	}
	public function getSaleAttribute() {
		if ($this->has_sale) {
			return $this->sale;
		}
		return 0;
	}
}