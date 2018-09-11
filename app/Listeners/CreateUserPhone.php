<?php

namespace App\Listeners;

use App\Events\ProfileWasCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateUserPhone
{
    /**
     * Handle the event.
     *
     * @param  UserSignedUp  $event
     * @return void
     */
    public function handle(ProfileWasCreated $event)
    {
        auth()->user()->phone()->create($event->phone);
    }
}
