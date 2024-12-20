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
            'accepted-equipment-reservation' => route('student.show_profile', $notification->data['student_id']),
            'facility-reservation' => route('facility_reservation_log', $notification->data['reservation_id']),
            
            default => route('notifications'),
        };

        return redirect($redirectUrl);
    }

    public function filter(Request $request)
    {
        $status = $request->input('status');
        $markAsRead = $request->input('mark_all_as_read'); // Check if we need to mark all as read
        $userId = Auth::user()->id;
        
        // Get notifications based on user ID
        $notifications = Notification::where('notifiable_id', $userId);

        // If the request indicates to mark all as read, mark all unread notifications as read
        if ($markAsRead) {
            // Mark all unread notifications as read for the authenticated user
            $notifications = $notifications->whereNull('read_at')->get(); // Only get unread notifications
            
            foreach ($notifications as $notification) {
                $notification->update(['read_at' => now()]); // Mark as read
            }
        }

        // Filter notifications based on the 'status' (read or unread)
        if ($status === 'read') {
            $notifications = $notifications->whereNotNull('read_at')->get();
        } elseif ($status === 'unread') {
            $notifications = $notifications->whereNull('read_at')->get();
        } else {
            // If no status filter is applied, just get all notifications
            $notifications = $notifications->get();
        }

        // Return the notifications view with the filtered notifications
        return view('notifications', compact('notifications'));
    }


    
}