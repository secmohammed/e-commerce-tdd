<?php

namespace Tests\Unit\Integration\Repositories;

use App\Exceptions\CouponCanNotBePurchasedException;
use App\Exceptions\CouponExpiredException;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;

class CouponRepositoryTest extends TestCase {
	public function setUp() {
		parent::setUp();
		$this->couponRepo = app('CouponRepository');
	}
	/** @test */
	public function it_generates_a_code() {
		$this->couponRepo->generate([
			'user_id' => auth()->id(),
		]);
		$this->assertEquals(32, strlen($this->couponRepo->first()->code));
	}
	/** @test */
	public function it_has_a_valid_coupon() {
		$coupon = $this->couponRepo->generate([
			'user_id' => auth()->id(),
			'amount' => 10,
			'active' => true,
		]);
		$this->assertTrue($this->couponRepo->validate($coupon));
		$coupon = $this->couponRepo->generate([
			'user_id' => auth()->id(),
			'amount' => 0,
			'active' => true,
		]);
		$this->assertFalse($this->couponRepo->validate($coupon));
		$anotherCoupon = $this->couponRepo->generate([
			'user_id' => auth()->id(),
			'expires_at' => Carbon::now()->subDays(7)->format('Y-m-d H:i:s'),
		]);
		$coupon->update([
			'active' => false,
		]);
		$this->assertFalse($this->couponRepo->validate($coupon));

		$this->expectException(CouponExpiredException::class);
		$this->couponRepo->validate($anotherCoupon);
	}
	/** @test */
	public function it_has_percentage() {
		$coupon = $this->couponRepo->generate([
			'user_id' => auth()->id(),
			'percentage' => 23.2,
		]);
		$this->assertEquals($coupon->percentage, 23.2);
	}
	/** @test */
	public function it_deactivates_a_coupon() {
		$coupon = $this->couponRepo->generate([
			'user_id' => auth()->id(),
		]);
		$this->assertTrue($this->couponRepo->deactivate($coupon->id));
		$this->expectException(ModelNotFoundException::class);
		$this->assertTrue($this->couponRepo->deactivate(10));
	}
	/** @test */
	public function it_activates_a_coupon() {
		$coupon = $this->couponRepo->generate([
			'user_id' => auth()->id(),
			'active' => false,
		]);
		$this->assertFalse($coupon->active);
		$this->assertTrue($this->couponRepo->activate($coupon->id));
	}
	/** @test */
	public function it_regenerates_a_coupon_code() {
		$coupon = $this->couponRepo->generate([
			'user_id' => auth()->id(),
		]);
		$code = $coupon->code;
		$this->assertNotEquals($this->couponRepo->regenerate($coupon->id)->code, $code);
		$this->assertEquals($this->couponRepo->regenerate($coupon->id, 'some-random-string')->code, 'some-random-string');
		$this->expectException(ModelNotFoundException::class);
		$this->couponRepo->regenerate(15);
	}
	/** @test */
	public function it_validates_and_regenerates_coupon() {
		$coupon = $this->couponRepo->generate([
			'user_id' => auth()->id(),
			'expires_at' => Carbon::now()->subDays(7)->format('Y-m-d H:i:s'),
		]);
		$this->expectException(CouponExpiredException::class);
		$this->couponRepo->regenerateAndValidate($coupon->id);
	}
	/** @test */
	public function it_can_purchase_to_a_coupon() {
		$user = factory(User::class)->create();
		$coupon = $this->couponRepo->generate([
			'user_id' => $user->id,
			'amount' => 10,
			'active' => true,
		]);
		$this->assertEquals(9, $this->couponRepo->purchase($coupon)->amount);
		$coupon = $this->couponRepo->generate([
			'user_id' => auth()->id(),
			'amount' => 10,
			'active' => true,
		]);
		$this->expectException(CouponCanNotBePurchasedException::class);
		$this->couponRepo->purchase($coupon);

	}
	/** @test */
	public function it_cannot_purchase_a_purchsed_coupon() {
		$user = factory(User::class)->create();
		$coupon = $this->couponRepo->generate([
			'user_id' => $user->id,
			'amount' => 10,
			'active' => true,
		]);
		$this->couponRepo->purchase($coupon);
		$this->expectException(CouponCanNotBePurchasedException::class);
		$this->couponRepo->purchase($coupon);
	}
	/** @test */
	public function it_can_release_only_purchased_coupons() {
		$user = factory(User::class)->create();
		$coupon = $this->couponRepo->generate([
			'user_id' => $user->id,
			'amount' => 10,
			'active' => true,
		]);
		$this->couponRepo->purchase($coupon);
		$this->assertEquals(0, $this->couponRepo->release($coupon)->users()->count());
	}
	/** @test */
	public function it_retrieves_applied_coupons_only() {
		$user = factory(User::class)->create();
		$coupon = app('CouponRepository')->generate([
			'user_id' => $user->id,
			'expires_at' => Carbon::now()->addDays(7)->format('Y-m-d H:i:s'),
			'active' => true,
			'amount' => 12,
		]);
		$anotherCoupon = app('CouponRepository')->generate([
			'user_id' => $user->id,
			'expires_at' => Carbon::now()->addDays(7)->format('Y-m-d H:i:s'),
			'active' => true,
			'amount' => 10,
		]);
		$this->couponRepo->purchase($coupon);
		$this->assertCount(1, $this->couponRepo->appliedCoupons($this->couponRepo->all()));
	}
}
