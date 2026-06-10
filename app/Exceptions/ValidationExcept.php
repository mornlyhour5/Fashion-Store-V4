<?php

namespace App\Exceptions;

use Exception;

class ValidationExcept extends Exception
{
    public function __construct($message = "Unprocessable")
    {
        parent::__construct($message,422);
    }
}
