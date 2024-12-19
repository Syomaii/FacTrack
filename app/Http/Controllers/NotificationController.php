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
        $status = $request->input('status'); // Get the status filter from the request
        $userId = Auth::user()->id; // Get the logged-in user's ID
    
        // Fetch notifications based on the filter
        $notifications = Notification::where('notifiable_id', $userId)
            ->when($status === 'read', function ($query) {
                $query->whereNotNull('read_at'); // Notifications with a `read_at` timestamp are "read"
            })
            ->when($status === 'unread', function ($query) {
                $query->whereNull('read_at'); // Notifications without a `read_at` timestamp are "unread"
            })
            ->orderBy('created_at', 'desc') // Order notifications by latest first
            ->get();
    
        return view('notifications', compact('notifications', 'status'));
    }
    


    public function readNotifications(){

    }
}