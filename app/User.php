<?php

namespace App;

use App\Contracts\UserInterface;
use SecTheater\Jarvis\User\EloquentUser;

class User extends EloquentUser implements UserInterface {
	public $observers = [
		'username' => 'startsWithUpper',
	];

	public function wishlist() {
		return $this->belongsToMany(Wishlist::class, 'user_wishlist');
	}
	public function cart() {
		return $this->belongsToMany(Cart::class, 'user_cart');
	}
	public function products() {
		return $this->hasMany(Product::class, 'user_id', 'id')->where('products.reviewed', '=', true);
	}
	public function coupons() {
		return $this->belongsToMany(Coupon::class, 'user_coupon', 'user_id', 'coupon_id')->withPivot('purchased');
	}
	/**
	 * retrieve the profile columns through relationship.
	 */
	protected function getFullName() {
		return ucwords($this->profile->first_name . ' ' . $this->profile->last_name);
	}
	public function getFirstName() {
		return $this->profile->first_name;
	}
	public function getProfilePicture() {
		return $this->profile->profile_picture;
	}
}