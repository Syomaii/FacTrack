<?php

namespace App\Console\Commands;

use App\Mail\OverdueEquipmentMail;
use App\Models\Borrower;
use App\Models\Students;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class NotifyOverdueEquipments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'equipment:notify-overdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify students about overdue equipment and update the status in the Borrows table.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get all borrowed equipment where the expected return date is past and not yet returned
        $overdueBorrowers = Borrower::whereNull('returned_date')
            ->where('expected_returned_date', '<', Carbon::now())
            ->get();

        foreach ($overdueBorrowers as $borrower) {
            // Get the student who borrowed the equipment
            $student = $borrower->student;  // Assuming you have a `student()` relationship in Borrower

            if ($student) {
                Mail::to($student->email)->send(new OverdueEquipmentMail($student)); // Send the email with student data
            }

            // Update the status of the equipment in the Borrows table to "Not Returned"
            $borrower->status = 'Not Returned';
            $borrower->save();

            $this->info('Notification sent to student: ' . $borrower->borrowers_name . ' for overdue equipment.');
        }

        $this->info('All overdue notifications have been sent.');
    }
}
