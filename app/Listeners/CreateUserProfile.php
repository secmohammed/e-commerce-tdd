<?php

namespace App\Listeners;

use App\Events\UserSignedUp;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateUserProfile
{
    /**
     * Handle the event.
     *
     * @param  UserSignedUp  $event
     * @return void
     */
    public function handle(ProfileWasCreated $event)
    {
        auth()->user()->profile()->create($event->profile);
    }
}
