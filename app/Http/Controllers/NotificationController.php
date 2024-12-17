<?php

namespace App\Http\Controllers;

use App\Models\Students;
use App\Models\User;
use App\Notifications\OverdueEquipmentsNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Request;

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
            'borrows' => route('student.show_profile', $notification->data['student_id']),
            default => route('notifications'),
        };

        return redirect($redirectUrl);
    }

    public function filter(Request $request)
    {
        $status = $request->input('status'); 
        $userId = Auth::user()->id; 

        $notifications = Notification::where('notifiable_id', $userId); // Filter by notifiable_id

        if ($status === 'read') {
            $notifications->whereNotNull('read_at');
        } elseif ($status === 'unread') {
            $notifications->whereNull('read_at');
        }

        $notifications = Auth::check() ? $notifications->get() : collect(); // Fetch the filtered notifications

        return view('notifications', compact('notifications'));
    }

    public function readNotifications(){

    }
}