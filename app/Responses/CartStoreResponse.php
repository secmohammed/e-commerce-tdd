<?php

namespace App\Responses;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Responsable;

class CartStoreResponse implements Responsable
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
        $this->cart = app('CartRepository');
    }

    public function toResponse($request)
    {
        $this->cart->checkAndAdd($this->id);

        cache()->forget('cart' . auth()->id());

        return redirect()->back();
    }
}