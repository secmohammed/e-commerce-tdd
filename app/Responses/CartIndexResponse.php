<?php

namespace App\Responses;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Responsable;

class CartIndexResponse implements Responsable
{
    public function toResponse($request)
    {
        cache()->remember('cart-' . auth()->id(), 10, function () {
            return auth()->user()->products;
        });

        return view('cart.index', ['products' => cache()->get('cart-' . auth()->id())]);
    }
}