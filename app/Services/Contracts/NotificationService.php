<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

interface NotificationService
{
    public function makeRead(int $id, int $userId);

    public function getNotificationUser(Request $request);

    public function getNotificationAdmin(Request $request);
}
