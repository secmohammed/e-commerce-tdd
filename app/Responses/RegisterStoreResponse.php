<?php

namespace App\Responses;

use App\Events\UserWasRegistered;
use Illuminate\Contracts\Support\Responsable;

class RegisterStoreResponse implements Responsable
{
    private $request;

    public function __construct($request)
    {
        $this->request = $request;
    }


    public function toResponse($request)
    {
        if ($user = jarvis()->registerWithRole($this->request)) {
            event(new UserWasRegistered($user));
            return resposne()->json(['message' => 'Hello There'],201);
        }
        return response()->json(['message' => 'Could not register'],401);
    }
}
