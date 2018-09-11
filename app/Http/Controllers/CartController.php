<?php

namespace App\Http\Controllers;

use App\Responses\{CartIndexResponse, CartStoreResponse, CartUpdateResponse, CartDestroyResponse};
use App\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function index()
    {
        return new CartIndexResponse;
    }

    public function store($id)
    {
        return new CartStoreResponse($id);
    }

    public function update($id)
    {
        return new CartUpdateResponse($id);
    }

    public function destroy($id)
    {
        return new CartDestroyResponse($id);
    }
}