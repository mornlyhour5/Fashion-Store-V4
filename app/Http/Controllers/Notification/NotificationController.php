<?php

namespace App\Http\Controllers\Notification;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\Contracts\NotificationService;
use Illuminate\Http\Request;

//use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct( protected NotificationService $notification){}

    public function index(Request $request)
    {
        return ApiResponse::success($this->notification->getNotification($request));
    }

    // public no
}
