<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\User;


use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getNotifications()
    {
        $userNotifications = auth()->user()->notifications()->get();
        return response()->json(['notifications' => $userNotifications]);

    }
}
