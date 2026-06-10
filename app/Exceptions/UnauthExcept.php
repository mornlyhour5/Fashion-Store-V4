<?php

namespace App\Exceptions;

use Exception;

class UnauthExcept extends Exception
{
    public function __construct($message = "Unauthorized")
    {
        parent::__construct($message,401);
    }
}
