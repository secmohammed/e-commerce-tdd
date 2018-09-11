<?php

namespace App\Listeners;

use App\Events\UserWasRegistered;
use App\Mail\Activation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendActivationMail implements ShouldQueue
{
    public function handle(UserWasRegistered $event)
    {
        \Mail::to($event->user->email)->send(new Activation($event->user,$event->user->activation->first()));
    }
}
