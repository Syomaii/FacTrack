<?php

namespace App\Listeners;

use App\Events\AcceptFacilityReservationEvent;
use App\Models\User;
use App\Notifications\AcceptFacilityReservationNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class AcceptFacilityReservationListener
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
    public function handle(AcceptFacilityReservationEvent $event): void
    {
        $student = User::find($event->reserver->id);
        // Send the notification
        Notification::send($student, new AcceptFacilityReservationNotification($event->reserver, $event->reservation, $event->facility));
    }
}
