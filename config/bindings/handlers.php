<?php

use Illuminate\Contracts\Debug\ExceptionHandler as ExceptionHandlerContract;
use App\Exceptions\Handler;

return [
    ExceptionHandlerContract::class => Handler::class,
];
