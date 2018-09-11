<?php

namespace App\Responses;
use App\Repositories\ProductRepository;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;

class ProductUpdateResponse implements Responsable
{
    protected $product;

    public function __construct($product,$request)
    {
        $this->product = $product;
        $this->request = $request;
    }

    public function toResponse($request)
    {
        $this->product->update($this->request);

        cache()->forget('products');

        return back();
    }
}