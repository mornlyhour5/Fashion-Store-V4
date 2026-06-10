<?php

namespace App\Exceptions;

use Exception;

class NotFoundExcept extends Exception
{
    public function __construct($message = "Not Found")
    {
        parent::__construct($message,404);
    }
}
