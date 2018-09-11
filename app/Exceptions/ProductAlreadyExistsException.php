<?php

namespace App\Exceptions;

use Exception;

class ProductAlreadyExistsException extends Exception
{
    protected $message = 'Product Already Exists, so are attributes';
}
