<?php

namespace App\Exceptions;

use Exception;

class ColumnNotFoundException extends Exception
{
    protected $message = 'Column Does not exist in the table.';
}