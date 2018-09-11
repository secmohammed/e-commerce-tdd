<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Responses\ProductCreateResponse;
use App\Http\Responses\ProductShowResponse;
use App\Http\Responses\ProductStoreResponse;
use App\Http\Responses\ProductUpdateResponse;
use App\Http\Responses\ProductShowUpdateFormResponse;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'])->except('show');
    }

    public function show(Product $product)
    {
        return new ProductShowResponse($product);
    }

    public function create()
    {
        return new ProductCreateResponse;
    }

    public function store(ProductStoreRequest $form)
    {
        return new ProductStoreResponse;
    }

    public function showUpdateForm(Product $product)
    {
        return new ProductShowUpdateFormResponse($product);
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        return new ProductUpdateResponse($product,$request->validated());
    }
}