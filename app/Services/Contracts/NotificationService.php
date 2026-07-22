<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

interface NotificationService
{
    public function getNotification(Request $request);
}
