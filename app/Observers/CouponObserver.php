<?php

namespace App\Observers;

use App\Coupon;

class CouponObserver {
	public function creating(Coupon $coupon) {
		if (!$coupon->code) {
			$coupon->code = str_random(32);
		}
	}
}