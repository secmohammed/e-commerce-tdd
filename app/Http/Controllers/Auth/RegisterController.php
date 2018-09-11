<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Responses\RegisterStoreResponse;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function store(RegisterRequest $request)
    {
        return new RegisterStoreResponse($request->validated());
    }
}
