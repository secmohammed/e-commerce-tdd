<?php

namespace App\Repositories;

use App\Contracts\CartInterface;
use App\Contracts\UserInterface;
use App\Traits\CanBeCarted;
use App\Wishlist;

class WishlistRepository extends Repository implements CartInterface {
	use CanBeCarted;
	protected $model, $typeRepo, $variationRepo;
	public function __construct(Wishlist $model) {
		$this->model = $model;
		$this->typeRepo = app('ProductVariationTypeRepository');
		$this->variationRepo = app('ProductVariationRepository');
	}
	public function pushWishToCart($wish, UserInterface $user = null) {
		if (!$wish instanceof Wishlist) {
			$wish = $this->findOrFail($wish);
		}
		$user = $user ?? auth()->user();
		$user->wishlist()->detach($wish);
		$this->getModelName = 'cart';
		return $this->add($wish->type, $wish->quantity, true);
	}
}