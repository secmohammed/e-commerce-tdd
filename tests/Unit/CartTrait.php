<?php

namespace Tests\Unit;

use App\Product;
use App\ProductVariation;
use App\ProductVariationType;

trait CartTrait {
	protected $product, $cart, $cartInstance, $productInstance, $typeRepo, $category;
	public function setUp() {
		parent::setUp();
		$this->category = factory(\App\Category::class)->create();
		auth()->user()->cart()->saveMany(factory(\App\Product::class, 3)->create()->each(function ($product) {
			$type = factory(ProductVariationType::class)->create([
				'product_id' => $product->id,
			]);

			factory(ProductVariation::class)->create([
				'product_id' => $product->id,
				'product_variation_type_id' => $type->id,
			]);
			$product->carts()->save(factory(\App\Cart::class)->create([
				'product_id' => $product->id,
				'product_variation_type_id' => $type->id,
			]));
			$product->wishlists()->save(factory(\App\Wishlist::class)->create([
				'product_id' => $product->id,
				'product_variation_type_id' => $type->id,
			]));
		}));
		auth()->user()->wishlist()->saveMany(Product::get());
		$this->cartInstance = app('CartRepository');
		$this->wishlistInstance = app('WishlistRepository');
		$this->productInstance = app('ProductRepository');
		$this->typeRepo = app('ProductVariationTypeRepository');
		$this->variationRepo = app('ProductVariationRepository');
		auth()->user()->cart()->save($this->cartInstance->first());
		auth()->user()->wishlist()->save($this->wishlistInstance->first());
		$this->product = auth()->user()->cart->first()->product->first();
		$this->cart = auth()->user()->cart->first();
		$this->wishlist = auth()->user()->wishlist->first();
	}

}