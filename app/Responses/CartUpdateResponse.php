<?php

namespace App\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;

class CartUpdateResponse implements Responsable
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
        $this->product = app('ProductRepository');
    }

    public function toResponse($request)
    {
        if ($this->cart->checkAndAdd($id,$request->quantity)) {
            cache()->forget('cart-' . auth()->id());

            return redirect()->back();
        }

        return redirect()->home();
    }
}