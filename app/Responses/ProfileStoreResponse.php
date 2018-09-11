<?php

namespace App\Responses;

use App\Events\ProfileWasCreated;
use Illuminate\Contracts\Support\Responsable;

class ProfileStoreResponse implements Responsable
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
        event(new ProfileWasCreated($this->profile,$this->address,$this->phone));
        return back();

    }
}
