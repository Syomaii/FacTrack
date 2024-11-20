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
    /**
     * Create a new notification instance.
     */
    public function __construct($student)
    {
        $this->student = $student;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('A student has been notified about overdue equipment.')
                    ->line('Student: ' . $this->student->firstname . ' ' . $this->student->lastname)
                    ->action('View Borrower', url('/student/' . $this->student->id)) // Adjust the URL based on your routes
                    ->line('Please ensure to take appropriate actions.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Overdue Equipment Notification',
            'message' => 'A student has been notified about overdue equipment: ' . $this->student->firstname . ' ' . $this->student->lastname,
        ];
    }
}