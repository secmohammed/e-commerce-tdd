<?php

namespace App\Providers;

use Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('joined', function ($expression) {
            return "<?= with($expression)->created_at->diffForHumans(); ?>";
        });

        Blade::if('privillege', function ($privillege, $user = null) {
            if (!isset($user))
                $user = auth()->user();

            return auth()->check() && $user->hasPrivillege($privillege);
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
