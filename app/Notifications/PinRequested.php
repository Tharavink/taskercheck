<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PinRequested extends Notification
{
    use Queueable;
    protected $user;
    protected $pin;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $pin)
    {
        $this->user = $user;
        $this->pin = $pin;
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
                    ->subject('Change Password Request')
                    ->greeting('Hello '.$this->user->name)
                    ->line('Please use the following pin to change your password.')
                    ->line($this->pin)
                    ->line('Thank you for using '.env('APP_NAME').'!');
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
