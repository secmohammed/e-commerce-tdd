<?php

namespace App\Responses;

use App\Events\ProfileWasUpdated;
use Illuminate\Contracts\Support\Responsable;

class ProfileUpdateResponse implements Responsable
{
    private $profile,$address,$phone;

    public function __construct($request)
    {
        $this->profile = $request->only(['first_name','last_name','location','about']);
        $this->address = $request->only(['street','city']);
        $this->phone = $request->only(['phone']);
    }


    public function toResponse($request)
    {
        event(new ProfileWasUpdated($this->profile,$this->address,$this->phone));
        return response()->json(['message' => 'Profile Updated'],201);
    }
}
