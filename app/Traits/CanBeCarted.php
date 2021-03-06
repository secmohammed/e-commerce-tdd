<?php
namespace App\Traits;

use App\Contracts\CartInterface;
use App\Contracts\UserInterface;
use App\Exceptions\InsufficientProductQuantity;
use App\Exceptions\ProductAttributesDoesNotMatchException;
use App\Exceptions\ProductDoesNotExist;
use App\Repositories\Traits\HasStock;

trait CanBeCarted {
	use HasStock;
	protected $subtotal;
	public function create(array $attributes) {
		return auth()->user()->{$this->getModelName}()->create($attributes);
	}
	public function canBeAdded(int $id, int $quantity = 1) {
		return ($this->typeRepo->stock($id) >= $quantity) && $quantity;
	}
	public function addOrCreate($product, int $quantity = 1) {
		return $this->add($product, $quantity, true);
	}
	public function add($type, int $quantity = 1, $create = false) {
		throw_unless($this->canBeAdded($type->id, $quantity), InsufficientProductQuantity::class);
		if ($this->getModelName != 'wishlist') {
			$this->typeRepo->decrementStock($type, $quantity);
		}
		if ($create) {
			$attributes = ['product_id' => $type->product_id, 'quantity' => $quantity, 'product_variation_type_id' => $type->id];
			return $this->create($attributes);
		}
		$cart = auth()->user()->{$this->getModelName}()->whereProductId($type->product_id);
		throw_unless($cart->first(), ProductDoesNotExist::class);
		$cart->increment('quantity', $quantity);
		return auth()->user()->{$this->getModelName}()->whereProductId($type->product_id)->first();
	}
	public function remove($id) {
		$cart = $this->item($id);
		$this->typeRepo->incrementStock($cart->type, $cart->quantity);
		return !!$cart->delete();
	}
	public function subtotal() {
		return $this->subtotal = auth()->user()->{$this->getModelName}()->get()->reduce(function ($carry, $cart) {
			$price = $cart->quantity * ($cart->type->price ?? $cart->product->price);
			if ($cart->product->has_sale) {
				$price -= $price * ($cart->product->sale / 100);
			}
			$carry += $price;
			return $carry;
		}, $this->subtotal = 0);
	}
	public function subtotalAfterCoupon($coupons) {
		return $this->subtotal = app('CouponRepository')->appliedCoupons($coupons)->reduce(function ($carry, $coupon) {
			return $carry -= $carry * ($coupon->percentage / 100);
		}, $this->subtotal());
	}
	public function total($coupons = null) {
		if (!$this->subtotal) {
			$this->subtotal = $coupons ? $this->subtotalAfterCoupon($coupons) : $this->subtotal();
		}

		if (config('cart.tax.enabled') && is_int(config('cart.tax.percentage')) && class_basename($this->model) == 'Cart') {
			return $this->subtotal * (config('cart.tax.percentage')) / 100;
		}
		return $this->subtotal;
	}
	public function items() {
		return auth()->user()->{$this->getModelName};
	}
	public function item($id, $attributes = null) {
		$cart = auth()->user()->{$this->getModelName}()->findOrFail($id);
		if ($attributes) {
			throw_unless($this->variationRepo->contains($cart->product_variation_type_id, $attributes), ProductAttributesDoesNotMatchException::class);
		}
		return $cart;
	}
	public function clearAll(UserInterface $user = null) {
		$user = $user ?? auth()->user();
		if ($this->getModelName == 'wishlist') {
			$released = $user->{$this->getModelName}()->count();
			$user->{$this->getModelName}()->detach();
			return $released;
		}

		$released = 0;
		$user->{$this->getModelName}->each(function ($item) use (&$released) {
			$released += $item->quantity;
			$item->type->increment('stock', $item->quantity);
		});
		return $released;
	}
	public function clearFor(UserInterface $user) {
		return $this->clearAll($user);
	}
	public function renew(CartInterface $cart, array $data) {
		throw_unless($this->canBeAdded($cart->product_id, $data['quantity'] ?? $cart->quantity), InsufficientProductQuantity::class);
		$this->typeRepo->decrementStock($cart->type, $data['quantity'] ?? 0);
		$cart->update($data);
		return $cart;
	}
	public function stock($cart) {
		$base = '\\App\\' . class_basename($this->model);
		if (!$cart instanceof $base) {
			$cart = $this->findOrFail($cart);
		}
		return $cart->type->stock;
	}

	public function __set($key, $value) {
		$this->{$key} = strtolower(class_basename($value));
	}
	public function __get($key) {
		if (!property_exists($this, $key)) {
			$this->{$key} = $this->model;
		}
		return $this->{$key};
	}
}