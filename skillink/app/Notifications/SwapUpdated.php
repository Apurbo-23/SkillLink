<?php

namespace App\Notifications;

use App\Models\SwapRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SwapUpdated extends Notification
{
    use Queueable;

    public function __construct(protected SwapRequest $swapRequest) {}

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "Your swap request for \"{$this->swapRequest->listing->skill_offered}\" is now {$this->swapRequest->status}.",
            'url' => route('swap-requests.show', $this->swapRequest),
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your swap status has changed')
            ->line("Your swap request for \"{$this->swapRequest->listing->skill_offered}\" is now: {$this->swapRequest->status}.")
            ->action('View Swap', route('swap-requests.show', $this->swapRequest));
    }
}