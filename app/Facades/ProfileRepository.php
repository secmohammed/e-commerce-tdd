<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ProfileRepository extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ProfileRepository';
    }
}