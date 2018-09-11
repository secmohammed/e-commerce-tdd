<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ProfileWasCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $profile,$address,$phone;

    public function __construct($profile, $address, $phone)
    {
        $this->profile = $profile;
        $this->address = $address;
        $this->phone = $phone;
    }

}
