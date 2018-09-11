<?php

namespace App\Listeners;

use App\Events\ProfileWasUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateUserProfile
{

    /**
     * Handle the event.
     *
     * @param  ProfileWasUpdated  $event
     * @return void
     */
    public function handle(ProfileWasUpdated $event)
    {
        auth()->user()->profile()->update($event->profile);
    }
}
