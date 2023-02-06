<?php

namespace App\Notifications\Games;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\GameWinnerEarnings;

class GameWinnerNotification extends Notification
{
    use Queueable;

    protected GameWinnerEarnings $gameWinnerEarning;

    public function __construct(GameWinnerEarnings $gameWinnerEarning) {
        $this->gameWinnerEarning = $gameWinnerEarning;
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
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject("You’re a Winner!")
                    ->line("Congratulations!!")
                    ->line("You have won {$this->gameWinnerEarning->earning} in the game {$this->gameWinnerEarning->game->name}.")
                    ->line("Please ensure your contact details are up to date and you have completed the steps within the ‘Verify Yourself’ tab. We will be in touch soon to discuss payment!");
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
