<?php

namespace App\Exceptions;

use Exception;

class UndefinedMethodException extends Exception
{
    protected $message = 'Call To Undefined Method';
}
