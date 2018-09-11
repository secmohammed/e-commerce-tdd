<?php

namespace Tests\Unit\Integration\Models;

use App\Category;
use App\Product;
use App\ProductVariation;
use App\ProductVariationType;
use App\Sale;
use App\User;
use Tests\TestCase;

class ProductTest extends TestCase {
	/** @test */
	public function it_has_many_categories() {
		$product = factory(Product::class)->create();
		$product->categories()->save(
			factory(Category::class)->create()
		);
		$this->assertInstanceOf(Category::class, $product->categories->first());
	}
	/** @test */
	public function it_has_owner() {
		$product = factory(Product::class)->create([
			'user_id' => auth()->id(),
		]);
		$this->assertInstanceOf(User::class, $product->owner);
		$this->assertEquals(auth()->id(), $product->owner->id);
	}
	// /** @test */
	public function it_has_many_coupons() {
		$product = factory(Product::class)->create([
			'user_id' => auth()->id(),
		]);
		$coupons = factory(Coupon::class, 2)->create([
			'user_id' => auth()->id(),
			'product_id' => $product->id,
		]);
		$product->coupons()->saveMany($coupons);
		$this->assertCount(2, $product->coupons);
	}
	/** @test */
	public function it_has_many_variations() {
		$product = factory(Product::class)->create();
		$type = factory(ProductVariationType::class)->create([
			'product_id' => $product->id,
		]);
		$product->variations()->save(
			factory(ProductVariation::class)->create([
				'product_id' => $product->id,
				'product_variation_type_id' => $type->id,
			])
		);
		$this->assertInstanceOf(ProductVariation::class, $product->variations->first());
	}
	/** @test */
	public function it_has_a_sale() {
		$product = factory(Product::class)->create();
		$anotherProduct = factory(Product::class)->create();
		$product->sales()->save(
			factory(Sale::class)->create([
				'saleable_id' => $product->id,
				'saleable_type' => 'product',
			])
		);
		$product->sales()->save(
			factory(Sale::class)->create([
				'saleable_id' => $product->id,
				'saleable_type' => 'product',
			])
		);
		$this->assertCount(2, $product->sales);
		$this->assertEquals(21.0, $product->getTotalSale());
	}
	/** @test */
	public function it_has_sale_on_category() {
		$category = factory(Category::class)->create([

			'id' => 1,
		]);
		$anotherCategory = factory(Category::class)->create([
			'id' => 2,
		]);
		$product = factory(Product::class)->create([
			'id' => 3,
		]);
		$category->sales()->save(
			factory(Sale::class)->create([
				'id' => 4,
				'saleable_id' => $category->id,
				'saleable_type' => 'category',
			])

		);
		$type = factory(ProductVariationType::class)->create([
			'id' => 5,
			'product_id' => $product->id,
		]);
		$anotherType = factory(ProductVariationType::class)->create([
			'id' => 6,
			'product_id' => $product->id,
		]);
		$type->sales()->save(
			factory(Sale::class)->create([
				'id' => 6,
				'saleable_id' => $type->id,
				'saleable_type' => 'product_type',
			])

		);
		$anotherType->sales()->save(
			factory(Sale::class)->create([
				'id' => 10,
				'saleable_id' => $anotherType->id,
				'saleable_type' => 'product_type',
			])

		);
		$anotherCategory->sales()->save(
			factory(Sale::class)->create([
				'id' => 7,
				'saleable_id' => $anotherCategory->id,
				'saleable_type' => 'category',
			])

		);
		$product->sales()->save(
			factory(Sale::class)->create([
				'id' => 8,
				'saleable_id' => $product->id,
				'saleable_type' => 'product',

			])
		);
		$anotherCategory->products()->attach($product);
		$category->products()->attach($product);
		$this->assertTrue($product->has_sale);
		$this->assertEquals(52.5, $product->sale);
	}
}
