<?php
namespace Tests\Unit\Repositories;
use App\Cart;
use App\Exceptions\InsufficientProductQuantity;
use App\Exceptions\ProductAttributesDoesNotMatchException;
use App\Product;
use App\ProductVariationType;
use App\Sale;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Tests\TestCase;
use Tests\Unit\CartTrait;

class CartRepositoryTest extends TestCase {
	use CartTrait;
	/** @test */
	public function it_checks_if_product_can_be_added_to_cart() {
		$type = $this->typeRepo->first();
		$this->assertTrue($this->cartInstance->canBeAdded($type->id, ($type->stock - 2)));
		$this->assertNotTrue($this->cartInstance->canBeAdded($type->id, ($type->stock + 2)));
		$this->assertTrue($this->cartInstance->canBeAdded($type->id, ($type->stock)));
	}
	/** @test */
	public function it_checks_if_user_has_item() {
		$this->assertInstanceOf(Cart::class, $this->cartInstance->item($this->cart->id));
		$this->assertInstanceOf(Cart::class, $this->cartInstance->item($this->cart->id, $this->cart->product->variations()->first()->details));
		$this->assertInstanceOf(Collection::class, $this->cartInstance->item($this->cart->id, $this->cart->product->variations()->first()->details)->product->variations);
		// partially existing.
		$this->assertInstanceOf(Collection::class, $this->cartInstance->item($this->cart->id, ['color' => 'blue', 'size' => 'L'])->product->variations);

		$this->expectException(ProductAttributesDoesNotMatchException::class);
		$this->cartInstance->item($this->cart->id, ['color' => 'random-color']);

		$this->expectException(ModelNotFoundException::class);
		$this->cartInstance->item(10);
	}
	/** @test */
	public function it_can_add_product_to_user() {
		$stock = $this->product->types->first()->stock;
		$this->assertInstanceOf(Cart::class, $this->cartInstance->add($this->product->types->first(), 3));
		$this->assertEquals($stock - 3, $this->product->types->first()->stock);
		$this->cartInstance->remove($this->cart->id);
		$this->assertInstanceOf(Cart::class, $this->cartInstance->add($this->product->types->first(), 3, true));
		$this->expectException(InsufficientProductQuantity::class);
		$this->cartInstance->add($this->product->types->first(), 1000);
	}
	/** @test */
	public function it_removes_from_cart() {
		$this->assertTrue($this->cartInstance->remove(auth()->user()->cart->first()->id));
		// product doesn't exist
		$this->expectException(ModelNotFoundException::class);
		$this->cartInstance->remove(10);
	}
	/** @test */
	public function it_check_stock_equals_after_removal() {
		$stock = $this->cartInstance->stock($this->cart) + $this->cartInstance->item($this->cart->id)->quantity;
		$this->assertTrue($this->cartInstance->remove($this->cart->id));
		$this->assertEquals($stock, $this->typeRepo->stock($this->cart->product_variation_type_id));

	}
	/** @test */
	public function it_clears_all_cart_for_specific_user() {
		$this->assertTrue(!!$this->cartInstance->clearFor(auth()->user()));
	}
	/** @test */
	public function it_calculates_the_subtotal_of_the_whole_cart() {
		auth()->user()->cart()->detach();
		auth()->user()->cart()->save(
			$this->cart = factory(Cart::class)->create([
				'product_id' => $this->product = factory(Product::class)->create(['price' => 1000]),
				'product_variation_type_id' => $variation = factory(ProductVariationType::class)->create([
					'product_id' => $this->product->id,
				]),
			])
		);
		$subtotal = $this->cartInstance->subtotal();
		$this->cart->product->sales()->save(
			factory(Sale::class)->create([
				'saleable_id' => $this->product->id,
				'saleable_type' => 'product',
				'percentage' => 10.5,
			])
		);
		$this->assertTrue($this->cart->product->has_sale);
		$this->assertEquals(10.5, $this->cart->product->sale);
		$this->assertEquals(10.5 / 100 * $this->cart->product->price, $this->cart->product->sale / 100 * $this->cart->product->price);
	}
	/** @test */
	public function it_calculates_the_subtotal_of_the_whole_cart_after_applying_coupons() {
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
		$subtotal = $this->cartInstance->subtotal();
		$subtotal -= $subtotal * ($coupon->percentage / 100);
		$this->assertEquals($subtotal, $this->cartInstance->subtotalAfterCoupon($coupon));
	}
	/** @test */
	public function it_fetches_total_price_of_all_cart() {
		config(['cart.tax.enabled' => false]);
		$this->assertEquals($this->cartInstance->subtotal(), $this->cartInstance->total());
		config(['cart.tax.enabled' => true]);
		$this->assertLessThan($this->cartInstance->subtotal(), $this->cartInstance->total());
	}
	/** @test */
	public function fetch_user_cart_items() {
		$this->assertInstanceOf(Collection::class, $this->cartInstance->items());
	}
	/** @test */
	public function fetch_user_specific_item_in_cart() {
		$this->assertInstanceOf(Cart::class, $this->cartInstance->item($this->cart->id));
	}
	/** @test */
	public function update_cart_quantity() {
		$this->assertInstanceOf(Cart::class, $this->cartInstance->renew($this->cart, ['quantity' => 2]));
		$this->assertEquals(2, $this->cartInstance->first()->quantity);
		$this->assertInstanceOf(Cart::class, $this->cartInstance->renew($this->cart, ['created_at' => date('Y-m-d H:i:s')]));
		$this->expectException(InsufficientProductQuantity::class);
		$this->cartInstance->renew($this->cart, ['quantity' => 100]);
	}
	/** @test */
	public function update_product_stock_after_updating_cart_quantity() {
		$stock = $this->cartInstance->stock($this->cart) - 2;
		$this->assertInstanceOf(Cart::class, $this->cartInstance->renew($this->cart, ['quantity' => 2]));
		$this->assertEquals($stock, $this->cartInstance->stock($this->cart));
	}
}
