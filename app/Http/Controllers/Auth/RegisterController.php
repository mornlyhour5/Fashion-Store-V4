<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Services\Contracts\AuthService;

class RegisterController extends Controller
{

    public function __construct(protected AuthService $registerservices){}

    public function register(Request $request)
    {
        $result = $this->registerservices->register($request);

        return ApiResponse::success($result,'Register Success');
    }
}
