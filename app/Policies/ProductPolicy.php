<?php

namespace App\Policies;

use App\User;
use \App\Product;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;
	public function rate(User $user)
	{
		return $user->hasRole('rate-product');
	}
	public function review(User $user)
	{
		return $user->hasRole('review-product');
	}

    public function view(User $user, Product $product)
    {
        return $user->hasRole('view-product');
    }

    public function create(User $user)
    {
        return $user->hasRole('create-product');
    }

    public function update(User $user, Product $product)
    {
        return $user->hasRole('update-product') || $product->user_id == $user->id;
    }

    public function delete(User $user, Product $product)
    {
        return $user->hasRole('delete-product') || $product->user_id == $user->id;
    }
}
