<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

interface NotificationService
{
    public function getNotificationUser(Request $request);

    public function getNotificationAdmin(Request $request);
}
