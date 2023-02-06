<?php

namespace App\Notifications\Users;

use App\Models\Game;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvitationCode extends Notification
{
    use Queueable;

    protected $game;
    protected $invitationCode;
    private $baseUrl;

    public function __construct(Game $game, string $invitationCode) {
        $this->game = $game;
        $this->invitationCode = $invitationCode;
        $this->baseUrl = config('app.client_url');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("CONGRATULATIONS!!")
            ->line("Your Invite a Friend Link has now been activated.")
            ->line("You can now share the link with your friends and family via any messaging service or Social Media platform. Each friend that plays will earn you 1 free credit.")
            ->line($this->baseUrl . '/register?token=' . $this->invitationCode)
            ->line('Why leave things to chance?!');
    }
}
