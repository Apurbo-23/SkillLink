<?php

namespace App\Notifications;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewMessageReceived extends Notification
{
    use Queueable;

    public function __construct(protected Message $message) {}

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "New message from {$this->message->sender->name}.",
            'url' => route('swap-requests.show', $this->message->swap_request_id),
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('You have a new message')
            ->line("{$this->message->sender->name} sent you a message.")
            ->action('View Conversation', route('swap-requests.show', $this->message->swap_request_id));
    }
}