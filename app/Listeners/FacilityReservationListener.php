<?php

namespace App\Listeners;

use App\Events\FacilityReservationEvent;
use App\Models\User;
use App\Notifications\FacilityReservationNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class FacilityReservationListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(FacilityReservationEvent $event): void
    {
        $users = User::where(function($query) use ($event) {
            $query->where('office_id', $event->reservation->office_id)
                  ->orWhere('office_id', 3);
        })
        ->where('type', '!=', 'student')
        ->where('type', '!=', 'faculty')
        ->get();
        // Send the notification
        Notification::send($users, new FacilityReservationNotification($event->reserver, $event->reservation, $event->facility));
    }
}
