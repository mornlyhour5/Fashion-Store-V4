<?php

namespace App\Exceptions;

use Exception;

class DuplicateExcept extends Exception
{
    public function __construct($message = "Duplicated")
    {
        parent::__construct($message,409);
    }
}
