<?php

namespace Tests\Unit\Integration\Models;

use App\Coupon;
use App\User;
use Tests\TestCase;

class CouponTest extends TestCase {
	public function setUp() {
		parent::setUp();
		$this->couponRepo = app('CouponRepository');
	}
	/** @test */
	public function it_has_an_owner() {
		$coupon = factory(Coupon::class)->create([
			'user_id' => auth()->id(),
		]);
		$this->assertInstanceOf(User::class, $coupon->owner);
	}
	/** @test */
	public function it_has_many_users_purchased_to() {
		$coupon = factory(Coupon::class)->create([
			'user_id' => auth()->id(),
		]);
		$coupon->users()->saveMany(
			factory(User::class, 3)->create()
		);
		$this->assertCount(3, $coupon->users);
	}
}
