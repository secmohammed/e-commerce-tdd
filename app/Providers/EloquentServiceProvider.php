<?php

namespace App\Providers;

use App\Cart;
use App\Category;
use App\Coupon;
use App\Product;
use App\ProductVariation;
use App\ProductVariationType;
use App\Profile;
use App\Repositories\CartRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CouponRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ProductVariationRepository;
use App\Repositories\ProductVariationTypeRepository;
use App\Repositories\ProfileRepository;
use App\Repositories\UserRepository;
use App\Repositories\WishlistRepository;
use App\User;
use App\Wishlist;
use Illuminate\Support\ServiceProvider;

class EloquentServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {
		//
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {
		$this->app->singleton('ProductVariationRepository', function () {
			return new ProductVariationRepository(new ProductVariation);
		});

		$this->app->singleton('ProductVariationTypeRepository', function () {
			return new ProductVariationTypeRepository(new ProductVariationType);
		});

		$this->app->singleton('CouponRepository', function () {
			return new CouponRepository(new Coupon);
		});

		$this->app->singleton('WishlistRepository', function () {
			return new WishlistRepository(new Wishlist);
		});

		$this->app->singleton('CategoryRepository', function () {
			return new CategoryRepository(new Category);
		});

		$this->app->singleton('UserRepository', function () {
			return new UserRepository(new User);
		});

		$this->app->singleton('ProfileRepository', function () {
			return new ProfileRepository(new Profile);
		});

		$this->app->singleton('ProductRepository', function () {
			return new ProductRepository(new Product);
		});

		$this->app->singleton('CartRepository', function () {
			return new CartRepository(new Cart);
		});
	}
}