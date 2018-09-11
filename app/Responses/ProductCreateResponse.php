<?php

namespace App\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;

class ProductCreateResponse implements Responsable
{
    public function toResponse($request)
    {
        return view('products.create');
    }
}