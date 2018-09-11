<?php
/**
 * TODO
 * Tax Process.
 * Push To Cart If reviewed.
 */
namespace App\Repositories;

use App\Cart;
use App\Contracts\CartInterface;
use App\Traits\CanBeCarted;

class CartRepository extends Repository implements CartInterface {
	use CanBeCarted;
	protected $model, $typeRepo, $variationRepo;
	protected $tax = false;
	public function __construct(Cart $model) {
		$this->model = $model;
		$this->typeRepo = app('ProductVariationTypeRepository');
		$this->variationRepo = app('ProductVariationRepository');

	}
}