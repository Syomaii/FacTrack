<?php

namespace App\Http\Controllers;

use App\Models\Students;
use App\Models\User;
use App\Notifications\OverdueEquipmentsNotification;

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

    
}