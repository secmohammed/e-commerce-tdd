<?php

namespace App\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;

class HomeIndexResponse implements Responsable
{
    public function toResponse($request)
    {
        cache()->remember('products', 10, function () {
            return \ProductRepository::where('stock', '>', 0)->get();
        });

        return view('home', ['products' => cache()->get('products')]);
    }
}