<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AcceptEquipmentReservationNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $reserver;
    protected $reservation;
    protected $equipment;
    public function __construct($reserver, $reservation, $equipment)
    {
        $this->reserver = $reserver;
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
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Reservation Equipment Accepted',
            'message' => 'Your equipment reservation for: ' . $this->equipment->name . 'has been accepted',
            'reservation_id' => $this->reservation->id,
            'notification_type' => 'accepted-equipment-reservation',
        ];
    }
}
