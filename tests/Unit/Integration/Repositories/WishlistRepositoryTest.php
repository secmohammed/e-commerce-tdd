<?php

namespace Tests\Unit\Repositories;

use App\Cart;
use App\Exceptions\InsufficientProductQuantity;
use App\Exceptions\ProductAttributesDoesNotMatchException;
use App\Product;
use App\User;
use App\Wishlist;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Tests\TestCase;
use Tests\Unit\CartTrait;

class WishlistRepositoryTest extends TestCase {
	use CartTrait;
	/** @test */
	public function it_checks_if_product_can_be_added_to_wishlist() {
		$type = $this->typeRepo->first();
		$this->assertTrue($this->wishlistInstance->canBeAdded($type->id, ($type->stock - 2)));
		$this->assertNotTrue($this->wishlistInstance->canBeAdded($type->id, ($type->stock + 2)));
		$this->assertTrue($this->wishlistInstance->canBeAdded($type->id, ($type->stock)));
	}
	/** @test */
	public function it_checks_if_user_has_item() {
		$this->assertInstanceOf(Wishlist::class, $this->wishlistInstance->item($this->wishlist->id));
		$this->assertInstanceOf(Wishlist::class, $this->wishlistInstance->item($this->wishlist->id, $this->wishlist->product->variations()->first()->details));
		$this->assertInstanceOf(Collection::class, $this->wishlistInstance->item($this->wishlist->id, $this->wishlist->product->variations()->first()->details)->product->variations);
		// partially existing.
		$this->assertInstanceOf(Collection::class, $this->wishlistInstance->item($this->wishlist->id, ['color' => 'blue', 'size' => 'L'])->product->variations);

		$this->expectException(ProductAttributesDoesNotMatchException::class);
		$this->wishlistInstance->item($this->wishlist->id, ['color' => 'random-color']);

		$this->expectException(ModelNotFoundException::class);
		$this->wishlistInstance->item(10);
	}
	/** @test */
	public function it_can_add_product_to_user() {
		$stock = $this->product->types->first()->stock;
		$this->assertInstanceOf(Wishlist::class, $this->wishlistInstance->add($this->product->types->first(), 3));
		$this->assertEquals($stock, $this->product->types->first()->stock);
		$this->wishlistInstance->remove($this->wishlist->id);
		$this->assertInstanceOf(Wishlist::class, $this->wishlistInstance->add($this->product->types->first(), 3, true));
		$this->expectException(InsufficientProductQuantity::class);
		$this->wishlistInstance->add($this->product->types->first(), 1000);
	}
	/** @test */
	public function it_removes_from_wishlist() {
		$this->assertTrue($this->wishlistInstance->remove(auth()->user()->wishlist->first()->id));
		// product doesn't exist
		$this->expectException(ModelNotFoundException::class);
		$this->wishlistInstance->remove(10);
	}
	/** @test */
	public function it_check_stock_equals_after_removal() {
		$stock = $this->wishlistInstance->stock($this->wishlist) + $this->wishlistInstance->item($this->wishlist->id)->quantity;
		$this->assertTrue($this->wishlistInstance->remove($this->wishlist->id));
		$this->assertEquals($stock, $this->typeRepo->stock($this->wishlist->product_variation_type_id));

	}
	/** @test */
	public function it_clears_all_wishlist_for_specific_user() {
		$this->assertEquals(auth()->user()->wishlist()->count(), $this->wishlistInstance->clearFor(auth()->user()));
	}
	/** @test */
	public function it_calculates_the_subtotal_of_the_whole_wishlist() {
		// silly test
		$this->assertGreaterThan(0, $this->wishlistInstance->subtotal());
	}
	/** @test */
	public function it_calculates_the_subtotal_of_the_whole_wishlist_after_applying_coupons() {
		$user = factory(User::class)->create();
		$couponRepo = app('CouponRepository');
		$coupon = $couponRepo->generate([
			'user_id' => $user->id,
			'expires_at' => Carbon::now()->addDays(7)->format('Y-m-d H:i:s'),
			'active' => true,
			'amount' => 12,
			'percentage' => 10.5,
		]);
		$anotherCoupon = $couponRepo->generate([
			'user_id' => $user->id,
			'expires_at' => Carbon::now()->addDays(7)->format('Y-m-d H:i:s'),
			'active' => true,
			'amount' => 10,
		]);
		$couponRepo->purchase($coupon);
		$subtotal = $this->wishlistInstance->subtotal();
		$subtotal -= $subtotal * ($coupon->percentage / 100);
		$this->assertEquals($subtotal, $this->wishlistInstance->subtotalAfterCoupon($coupon));
	}
	/** @test */
	public function it_fetches_total_price_of_all_wishlist() {
		$this->assertEquals($this->wishlistInstance->subtotal(), $this->wishlistInstance->total());
	}
	/** @test */
	public function fetch_user_wishlist_items() {
		$this->assertInstanceOf(Collection::class, $this->wishlistInstance->items());
	}
	/** @test */
	public function fetch_user_specific_item_in_wishlist() {
		$this->assertInstanceOf(Wishlist::class, $this->wishlistInstance->item($this->wishlist->id));
	}
	/** @test */
	public function update_wishlist_quantity() {
		$this->assertInstanceOf(Wishlist::class, $this->wishlistInstance->renew($this->wishlist, ['quantity' => 2]));
		$this->assertEquals(2, $this->wishlistInstance->first()->quantity);
		$this->assertInstanceOf(Wishlist::class, $this->wishlistInstance->renew($this->wishlist, ['created_at' => date('Y-m-d H:i:s')]));
		$this->expectException(InsufficientProductQuantity::class);
		$this->wishlistInstance->renew($this->wishlist, ['quantity' => 100]);
	}
	/** @test */
	public function update_product_stock_after_updating_wishlist_quantity() {
		$stock = $this->wishlistInstance->stock($this->wishlist) - 2;
		$this->assertInstanceOf(Wishlist::class, $this->wishlistInstance->renew($this->wishlist, ['quantity' => 2]));
		$this->assertEquals($stock, $this->wishlistInstance->stock($this->wishlist));
	}
	/** @test */
	public function it_pushes_the_wish_to_cart() {
		$stock = $this->wishlistInstance->first()->stock;
		$cart = $this->wishlistInstance->pushWishToCart($this->wishlistInstance->first());
		$this->assertInstanceOf(Cart::class, $cart);
		$this->assertEquals($stock, $cart->stock);
	}
}
