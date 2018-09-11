<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Responses\LoginStoreResponse;
use Illuminate\Http\Request;
class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        return new LoginStoreResponse($request->validated());
    }
    public function destroy()
    {
        jarvis()->logout();
    }
}
