<?php

namespace App\Listeners;

use App\Events\ProfileWasCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateUserAddress
{
    /**
     * Handle the event.
     *
     * @param  UserSignedUp  $event
     * @return void
     */
    public function handle(ProfileWasCreated $event)
    {
        auth()->user()->address()->create($event->address);
    }
}
