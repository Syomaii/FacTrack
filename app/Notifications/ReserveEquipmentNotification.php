<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReserveEquipmentNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $student;
    protected $reservation;
    protected $equipment;
    public function __construct($student, $reservation, $equipment)
    {
        $this->student = $student;
        $this->reservation = $reservation;
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
            'title' => 'New Equipment Reservation',
            'message' => $this->student->firstname . ' ' . $this->student->lastname . 
                ' has requested a reservation for the equipment: ' . $this->equipment->name,
            'reservation_id' => $this->reservation->id,
            'notification_type' => 'reservation',
        ];
    }
}
