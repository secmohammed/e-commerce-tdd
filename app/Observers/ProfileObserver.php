<?php

namespace App\Observers;

use App\Profile;
use SecTheater\Jarvis\Observers\BaseObserver;

class ProfileObserver extends BaseObserver
{
    public function creating(Profile $profile)
    {
        $this->fireObserversListeners($profile);
    }
    public function updating(Profile $profile)
    {
        $this->fireObserversListeners($profile);
    }
}