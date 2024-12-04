<?php

namespace App\Listeners;

use App\Events\OverdueEquipmentEvent;
use App\Mail\OverdueEquipmentMail;
use App\Models\Borrower;
use App\Models\User;
use App\Notifications\OverdueEquipmentsNotification;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;


class OverdueEquipmentListener
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
    public function handle(OverdueEquipmentEvent $event): void
    {
        $overdueBorrowers = Borrower::whereNull('returned_date')
            ->where('expected_returned_date', '<', Carbon::now())
            ->get();

        foreach ($overdueBorrowers as $borrower) {

            $student = $borrower->student;  

            if ($student) {
                
                Mail::to($student->email)->send(new OverdueEquipmentMail($student));

                $users = User::where('office_id', $event->equipment->facility->office_id)
                    ->where('type', '!=', 'student')->get(); 

                    Log::info('Event Data:', [
                        $event->equipment->facility->office_id
                    ]);
                    
                Notification::send($users, new OverdueEquipmentsNotification($event->student, $event->borrower, $event->equipment));
                

                // Update the status of the equipment in the Borrows table to "Not Returned"
                $borrower->status = 'Not Returned';
                $borrower->save();

            }
        }

    }
}
