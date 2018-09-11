<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model {
	protected $guarded = ['id'];
	protected $dates = ['expires_at'];
	public function owner() {
		return $this->belongsTo(User::class, 'user_id');
	}
	public function users() {
		return $this->belongsToMany(User::class, 'user_coupon', 'coupon_id', 'user_id')->withPivot('purchased');
	}
}
