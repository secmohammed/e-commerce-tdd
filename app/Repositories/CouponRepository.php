<?php

namespace App\Repositories;

use App\Contracts\UserInterface;
use App\Coupon;
use App\Exceptions\CouponCanNotBePurchasedException;
use App\Exceptions\CouponExpiredException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class CouponRepository extends Repository {
	protected $model;

	public function __construct(Coupon $model) {
		$this->model = $model;
	}
	public function generate($data) {
		return $this->model->create($data);
	}
	public function validate(Coupon $coupon) {
		throw_if($coupon->expires_at && $coupon->expires_at < Carbon::now()->format('Y-m-d H:i:s'), CouponExpiredException::class);
		return $coupon->active && $coupon->amount;
	}
	public function deactivate($id) {
		return !!$this->model->findOrFail($id)->update(['active' => false]);
	}
	public function activate($id) {
		return !!$this->model->findOrFail($id)->update(['active' => true]);
	}
	public function regenerate($id, $code = null, bool $check = false) {
		$coupon = $this->model->findOrFail($id);
		if ($check) {
			$this->validate($coupon);
		}
		$coupon->update(['code' => $code ?? str_random(32)]);
		return $coupon;
	}
	public function regenerateAndValidate($id, $code = null) {
		return $this->regenerate($id, $code, true);
	}
	public function purchase(Coupon $coupon, UserInterface $user = null) {
		$user = $user ?? auth()->user();
		throw_unless($this->validate($coupon), CouponExpiredException::class);
		throw_if($user->id == $coupon->owner->id || $coupon->whereHas('users', function ($query) use ($user) {
			$query->whereUserId($user->id);
		})->count(), CouponCanNotBePurchasedException::class);
		$coupon->decrement('amount');
		$coupon->users()->attach($user);
		return $coupon;
	}
	public function release(Coupon $coupon, UserInterface $user = null) {
		auth()->user()->coupons()->detach($coupon);
		return $this;
	}
	public function releaseIfNotValid(Coupon $coupon) {
		try {
			return $this->validate($coupon) ?: !!!$this->release($coupon);
		} catch (CouponExpiredException $e) {
			$this->release($coupon);
		}
		return false;
	}
	public function purchased() {
		return auth()->user()->coupons->filter(function ($coupon) {
			return $this->releaseIfNotValid($coupon);
		});
	}
	public function appliedCoupons($coupons) {
		/**
		 * if the coupons aren't collection, they aren't object yet,so we will pass the coupons to the find   * method, which will retrieve either a model instance or collection of models depending on the passed argument.
		 */
		if (!is_object($coupons) && (is_int($coupons) || is_array($coupons))) {
			$coupons = $this->find($coupons);
		}
		// if the coupons are already passed as collection , or the argument that passed to find was an array.
		if ($coupons instanceof Collection) {
			return $this->purchased()->whereIn('id', $coupons->pluck('id'));
		}
		// if the passed argument to find is an integer , we have an instanceof model.
		return $this->purchased()->where('id', $coupons->id);
	}
}