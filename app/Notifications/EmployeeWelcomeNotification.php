<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmployeeWelcomeNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected string $password,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Welcome to the System')
            ->greeting("Hello, {$notifiable->name}!")
            ->line('Your employee account has been created. You can now log in using the credentials below.')
            ->line('**Email:** '.$notifiable->email)
            ->line('**Password:** '.$this->password)
            ->line('Please change your password after your first login.')
            ->action('Log In', url('/'))
            ->line('If you have any questions, please contact the administrator.');
    }
}
