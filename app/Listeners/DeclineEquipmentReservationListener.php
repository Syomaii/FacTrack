<?php

namespace App\Listeners;

use App\Events\DeclineEquipmentReservationEvent;
use App\Models\User;
use App\Notifications\DeclineEquipmentReservationNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class DeclineEquipmentReservationListener
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
    public function handle(DeclineEquipmentReservationEvent $event): void
    {
        $student = User::find($event->reserver->id);
        // Send the notification
        Notification::send($student, new DeclineEquipmentReservationNotification($event->reserver, $event->reservation, $event->equipment));
    }
}
