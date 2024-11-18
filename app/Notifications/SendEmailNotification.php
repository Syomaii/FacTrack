<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendEmailNotification extends Notification
{
    use Queueable;

    private $details;

    /**
     * Create a new notification instance.
     */
    public function __construct($details)
    {
        $this->details=$details;
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
        if ($this->details['type'] === 'reset') {
            return $this->toResetPasswordMail($notifiable);
        }
        
        return (new MailMessage)
                    ->subject('New User Verification')
                    ->greeting('Good Day!')
                    ->line('Please click the link to change your password')
                    ->action('Change my password', 'http://localhost:8000')
                    ->line('Thank You! ');
    }

    public function toResetPasswordMail(object $notifiable): MailMessage
    {
        $resetUrl = url('/password/reset?token=' . $this->details['token'] . '&email=' . urlencode($this->details['email']));
    
        return (new MailMessage)
            ->subject('Password Reset Request')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('An admin has reset your password. Click the link below to set a new password.')
            ->action('Reset My Password', $resetUrl)
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
            //
        ];
    }
}
