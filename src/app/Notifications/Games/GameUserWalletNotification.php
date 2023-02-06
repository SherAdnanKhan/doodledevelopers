<?php

namespace App\Notifications\Games;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GameUserWalletNotification extends Notification
{
    use Queueable;

    protected $invitedUser;

    public function __construct($invitedUser) {
        $this->invitedUser = $invitedUser;
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
        $invitedUser = $this->invitedUser->first_name;
        return (new MailMessage)
            ->subject("Free credit!")
            ->line("CONGRATULATIONS!")
            ->line("Your friend, {$invitedUser}, used your invitation link, you will now see 1 free credit has been added to your wallet.")
            ->line("But don’t stop there, the more friends that play, the more credits you will earn!")
            ->line("Why Leave Things to Chance?");
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
