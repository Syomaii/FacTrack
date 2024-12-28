<?php

namespace App\Listeners;

use App\Events\ForMaintenanceEvent;
use App\Models\User;
use App\Notifications\ForMaintenanceNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class ForMaintenanceListener
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
    public function handle(ForMaintenanceEvent $event): void
    {
        $users = User::where('office_id', $event->repairs->facility->office_id)
            ->where('type', '!=', 'student')
            ->where('type', '!=', 'faculty')->get();
        Notification::send($users, new ForMaintenanceNotification($event->repairs));
    }
}
