<?php

namespace App\Responses;

use Illuminate\Contracts\Support\Responsable;

class ChangePasswordUpdateResponse implements Responsable
{
    private $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function toResponse($request)
    {
        if (jarvis()->changePassword($this->request->old_password,$this->request->password)) {
            return response()->json(['message' => 'Password has been changed successfully'],201);
        }
        return response()->json(['message' => 'Password could not be changed'],201);

    }
}
