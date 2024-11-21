<?php

namespace App\Http\Controllers;

use App\Models\Students;
use App\Models\User;
use App\Notifications\OverdueEquipmentsNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function sendOverdueEquipmentNotification(Students $student)
    {
        // Find the facility manager(s) or users responsible for notifications
        $facilityManagers = User::where('type', 'facility manager')->get();

        if ($facilityManagers->isEmpty()) {
            return response()->json(['error' => 'No facility managers found'], 404);
        }

        foreach ($facilityManagers as $facilityManager) {
            // Send the notification to each facility manager
            $facilityManager->notify(new OverdueEquipmentsNotification($student));
        }

        return response()->json(['message' => 'Notification sent to facility managers']);
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead(); // This sets `read_at` to the current timestamp
        }

        return redirect()->back(); // Redirect back to the notifications page
    }


}