<?php

namespace App\Providers;

use App\Product;
use Illuminate\Support\ServiceProvider;

class EloquentEventServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap services.
	 *
	 * @return void
	 */
	public function boot() {
		Product::observe(\App\Observers\ProductObserver::class);
		\App\Profile::observe(\App\Observers\ProfileObserver::class);
		\App\Coupon::observe(\App\Observers\CouponObserver::class);
	}

	/**
	 * Register services.
	 *
	 * @return void
	 */
	public function register() {
		//
	}
}
