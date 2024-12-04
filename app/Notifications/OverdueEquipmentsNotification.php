<?php

namespace App\Notifications;

use App\Models\Students;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OverdueEquipmentsNotification extends Notification
{
    use Queueable;
    protected $student;
    protected $borrower;
    protected $equipment;
    /**
     * Create a new notification instance.
     */
    public function __construct($student, $borrower, $equipment)
    {
        $this->student = $student;
        $this->borrower = $borrower;
        $this->equipment = $equipment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Overdue Equipment Notification',
            'message' => 'Student ' . $this->student->firstname . ' ' . $this->student->lastname . 
                    'has been notified about overdue equipment: ' . $this->equipment->name,
            'student_id' => $this->student->id,

            'notification_type' => 'borrows'
        ];
    }
}
