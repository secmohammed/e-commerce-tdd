<?php

namespace App\Responses;

use Illuminate\Contracts\Support\Responsable;

class LoginStoreResponse implements Responsable
{
    private $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function toResponse($request)
    {
        if(jarvis()->login($request)){
            return response()->json('loggedin',200);
        }
        return response()->json(['message' => 'Could not log you in'],401);
    }
}
