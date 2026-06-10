<?php

namespace App\Exceptions;

use Exception;

class UnexpectedExcept extends Exception
{
    public function __construct($message = "Internal Server Error")
    {
        parent::__construct($message,500);
    }
}
