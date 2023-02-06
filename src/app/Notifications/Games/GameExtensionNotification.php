<?php

namespace App\Notifications\Games;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GameExtensionNotification extends Notification
{
    use Queueable;

    protected $extensionEndDate;
    protected $gameName;

    public function __construct($gameName, $extensionEndDate) {
        $this->gameName = $gameName;
        $this->extensionEndDate = $extensionEndDate;
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
            ->subject("Game extension notification")
            ->line("We’d like to inform you that {$this->gameName} has been extended until {$this->extensionEndDate}. Can you improve your score in that time?");
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
