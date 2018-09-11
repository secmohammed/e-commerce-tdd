<?php

namespace App;

use App\Repositories\Traits\HasSale;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Category extends Model {
	use HasSale;
	protected $guarded = [];

	public function products() {
		return $this->belongsToMany(Product::class);
	}
	public function sales() {
		return $this->morphMany(Sale::class, 'saleable');
	}

	public function scopeParents(Builder $builder) {
		$builder->whereNull('parent_id');
	}
	public function children() {
		return $this->hasMany(self::class, 'parent_id', 'id');
	}
}
