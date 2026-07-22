<?php

namespace App\Services\Notification;

use App\Repository\Contracts\NotificationRepository;
use App\Services\Contracts\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationServiceImpl implements NotificationService
{
    public function __construct(protected NotificationRepository $notification) { }

    public function getNotification(Request $request)
    {
        $userId = Auth::guard('api')->id();

        if (!$userId) {
            throw new \App\Exceptions\UnauthExcept();
        }

        return $this->notification->pagination(
            fileters: $request->all(),
            conditions: ['user_id' => $userId],
            limit: (int) $request->input('per_page', 20),
            rawSort: $request->input('sort', '-created_at'),
        );
    }
}
