<?php

namespace App\Listeners;

use App\Events\AcceptEquipmentReservationEvent;
use App\Models\Students;
use App\Models\User;
use App\Notifications\AcceptEquipmentReservationNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class AcceptEquipmentReservationListener
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
    public function handle(AcceptEquipmentReservationEvent $event): void
    {
        $student = User::find($event->reserver->id);
        // Send the notification
        Notification::send($student, new AcceptEquipmentReservationNotification($event->reserver, $event->reservation, $event->equipment));
    }
}
