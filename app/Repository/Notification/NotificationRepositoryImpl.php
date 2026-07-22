<?php

namespace App\Repository\Notification;

use App\Models\Notifications;
use App\Repository\BaseRepositoryImpl;
use App\Repository\Contracts\NotificationRepository;

class NotificationRepositoryImpl extends BaseRepositoryImpl implements NotificationRepository
{
    public function __construct(Notifications $notifications)
    {
        $this->model = $notifications;
    }
}
