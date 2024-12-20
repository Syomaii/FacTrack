<?php

namespace App\Listeners;

use App\Events\DeclineFacilityReservationEvent;
use App\Models\User;
use App\Notifications\DeclineFacilityReservationNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class DeclineFacilityReservationListener
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
    public function handle(DeclineFacilityReservationEvent $event): void
    {
        $student = User::find($event->reserver->id);
        // Send the notification
        Notification::send($student, new DeclineFacilityReservationNotification($event->reserver, $event->reservation, $event->facility));
    }
}
