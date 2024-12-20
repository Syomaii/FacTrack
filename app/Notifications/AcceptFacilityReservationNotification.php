<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AcceptFacilityReservationNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $reserver;
    protected $reservation;
    protected $facility;
    public function __construct($reserver, $reservation, $facility)
    {
        $this->reserver = $reserver;
        $this->reservation = $reservation;
        $this->facility = $facility;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Reservation Facility Accepted',
            'message' => 'Your facility reservation for: ' . $this->facility->brand .  ' has been accepted',
            'reservation_id' => $this->reservation->id,
            'notification_type' => 'accepted-facility-reservation',
        ];
    }
}
