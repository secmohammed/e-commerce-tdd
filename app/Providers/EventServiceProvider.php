<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\ProfileWasUpdated' => [
            'App\Listeners\UpdateUserAddress',
            'App\Listeners\UpdateUserPhone',
            'App\Listeners\UpdateUserProfile'
        ],
        'App\Events\UserWasRegistered' => [
            'App\Listeners\SendActivationMail'
        ],
        'App\Events\ProfileWasCreated' => [
            'App\Listeners\CreateUserAddress',
            'App\Listeners\CreateUserPhone',
            'App\Listeners\CreateUserProfile'
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
