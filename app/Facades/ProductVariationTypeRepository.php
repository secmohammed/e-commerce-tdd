<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ProductVariationTypeRepository extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ProductVariationTypeRepository';
    }
}