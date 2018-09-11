<?php

namespace App\Responses;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;

class ProductShowResponse implements Responsable
{
    protected $product;

    public function __construct($product)
    {
        $this->product = $product;
    }

    public function toResponse($request)
    {
        return view('products.show', ['product' => $this->product]);
    }
}