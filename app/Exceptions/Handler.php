<?php

namespace App\Exceptions;

use App\Helpers\ApiResponse;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        BadRequestExcept::class,
        NotFoundExcept::class,
        UnauthExcept::class,
        UnexpectedExcept::class,
        ValidationExcept::class,
        DuplicateExcept::class,
    ];

    public function report(\Throwable $e): void
    {
        parent::report($e);
    }

    public function render($request, Throwable $e)
    {
        dd([
        'exception' => get_class($e),
        'message'   => $e->getMessage(),
        'file'      => $e->getFile(),
        'line'      => $e->getLine(),
    ]);
        if ($e instanceof ThrottleRequestsException) {
            return ApiResponse::ManyRequest();
        }

        if ($e instanceof BindingResolutionException) {
            dd($e->getMessage());
        }
        if($request->wantsJson() || str_starts_with($request->path(), 'api/')){

            if ($e instanceof BadRequestExcept) {
                return ApiResponse::error(400, 'Bad Request', $e->getMessage());
            }
            if ($e instanceof NotFoundExcept) {
                return ApiResponse::error(404, 'Not Found', $e->getMessage());
            }
            if ($e instanceof UnauthExcept) {
                return ApiResponse::error(401, 'Unauthorized', $e->getMessage());
            }
            if ($e instanceof ValidationExcept ) {
                return ApiResponse::error(422, 'Unprocessable', $e->getMessage());
            }
            if ($e instanceof DuplicateExcept ) {
                return ApiResponse::error(409, 'Duplicated', $e->getMessage());
            }
            if ($e instanceof UnexpectedExcept) {
                return ApiResponse::error(500, 'Error', 'Internal Server Error');
            }

            if ($e instanceof HttpException) {
                return match ($e->getStatusCode()) {
                    500 => ApiResponse::error(500, 'Error', 'Something went wrong'),
                    405 => ApiResponse::error(405, 'Method Not Allowed', 'Method Not Allowed'),

                    401 => ApiResponse::error(401, 'Unauthorized', 'Unauthorized'),
                    404 => ApiResponse::error(404, 'Not Found', 'Resource not found'),
                    default => ApiResponse::error($e->getStatusCode(), 'Error', 'Internal Server Error'),
                };
            }
            return ApiResponse::error(500, 'Error', 'Internal Server Error');
        }
        return parent::render($request,$e);
    }
}
