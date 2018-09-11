<?php

namespace App\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;

class ProductStoreResponse implements Responsable
{
    private $product;

    public function __construct()
    {
        $this->product = app('ProductRepository');
    }


    public function toResponse($request)
    {
        $this->product->create([
            'title'             => strtolower(request()->title),
            'description'       => request()->description,
            'price'             => request()->price,
            'stock'             => request()->stock,
        ]);

        cache()->forget('products');

        return redirect()->home();
    }
}