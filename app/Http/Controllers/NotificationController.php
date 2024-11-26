<?php

namespace App\Http\Controllers;

use App\Models\Students;
use App\Models\User;
use App\Notifications\OverdueEquipmentsNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    

    public function redirect($id)
    {
        $notification = Auth::user()->notifications()->find($id);

        if (!$notification->read_at) {
            $notification->markAsRead();
        }

        // Determine redirect URL based on notification_type
        $redirectUrl = match($notification->data['notification_type'] ?? '') {
            'reservation' => route('reservation_details', $notification->data['reservation_id']),
            default => route('notifications', $notification->id),
        };

        return redirect($redirectUrl);
    }

}