<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search()
    {
        $results = \App\Product::where('title', 'LIKE', '%' . strtolower(request('search')) . '%')->get();

        return view('products.search', compact('results'));
    }
}