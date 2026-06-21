<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class VerifyEmailChangeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $newEmail,
        public string $token
    ) {}

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
        $url = URL::temporarySignedRoute(
            'email.change.verify',
            now()->addDays(7),
            ['id' => $notifiable->getKey(), 'token' => $this->token]
        );

        return (new MailMessage)
            ->subject('Confirm Email Address Change')
            ->line('You have requested to change your email address to ' . $this->newEmail . '.')
            ->line('Please click the button below to confirm your new email address.')
            ->action('Confirm New Email', $url)
            ->line('If you did not request an email change, please ignore this email.');
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
