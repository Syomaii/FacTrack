<?php

namespace App\Listeners;

use App\Events\ReserveEquipmentEvent;
use App\Models\Equipment;
use App\Models\User;
use App\Notifications\ReserveEquipmentNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendReservationListener
{
    /**
     * Create the event listener.
     */

    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(ReserveEquipmentEvent $event): void
    {
        $users = User::where('office_id', $event->reservation->office_id)
            ->where('type', '!=', 'student')
            ->where('type', '!=', 'faculty')->get();
        // Send the notification
        Notification::send($users, new ReserveEquipmentNotification($event->reserver, $event->reservation, $event->equipment));
    }
}
