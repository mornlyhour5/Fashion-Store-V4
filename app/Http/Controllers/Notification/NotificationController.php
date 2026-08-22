<?php

namespace App\Http\Controllers\Notification;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\Contracts\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct( protected NotificationService $notification){}

    public function index(Request $request)
    {
        return ApiResponse::success($this->notification->getNotificationUser($request));
    }

    // for admin
    public function getNotificationAdmin(Request $request)
    {
        return ApiResponse::success($this->notification->getNotificationAdmin($request));
    }

    public function makeRead(int $id)
    {
        $userId = Auth::guard('api')->id();

        return ApiResponse::success(
            $this->notification->makeRead($id, $userId)
        );
    }
}
