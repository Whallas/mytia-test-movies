<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class InvitationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $invitation;

    public function __construct($invitation)
    {
        $this->invitation = $invitation;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = URL::temporarySignedRoute(
            'register.show',
            now()->addHours(48),
            ['invitation' => $this->invitation->id]
        );

        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('You are invited!')
            ->line('You have been invited to join our platform.')
            ->action('Register Now', $url)
            ->line('This invitation will expire in 48 hours.');
    }
}
