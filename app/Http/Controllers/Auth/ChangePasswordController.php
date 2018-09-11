<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Responses\ChangePasswordUpdateResponse;

class ChangePasswordController extends Controller
{

    public function update(ChangePasswordRequest $request)
    {
        return new ChangePasswordUpdateResponse($request->validated());
    }
}
