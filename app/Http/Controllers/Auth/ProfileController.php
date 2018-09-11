<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequestForm;
use App\Responses\ProfileStoreResponse;
use App\Responses\ProfileUpdateResponse;

class ProfileController extends Controller
{
    public function update(ProfileRequestForm $request)
    {
        return new ProfileUpdateResponse($request->validated());
    }

    public function store(ProfileRequestForm $request)
    {
        return new ProfileStoreResponse($request->validated());
    }
}