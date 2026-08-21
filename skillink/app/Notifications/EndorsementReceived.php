<?php

namespace App\Notifications;

use App\Models\Endorsement;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class EndorsementReceived extends Notification
{
    use Queueable;

    public function __construct(protected Endorsement $endorsement) {}

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "{$this->endorsement->endorser->name} endorsed you for {$this->endorsement->skill}.",
            'url' => route('dashboard'),
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('You received a new endorsement!')
            ->line("{$this->endorsement->endorser->name} endorsed you for {$this->endorsement->skill}.");
    }
}