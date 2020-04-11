<?php

namespace FederalSt\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CustomerNotification extends Notification
{
    use Queueable;

    public $fromName;
    public $fromEmail;
    public $subject;
    public $message;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($fromName, $fromEmail, $subject, $message)
    {
        $this->fromName         = $fromName;
        $this->fromEmail        = $fromEmail;
        $this->subject          = $subject;
        $this->message          = $message;
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
                               ->from($this->fromEmail, $this->fromName)
                               ->subject($this->subject)
                               ->line($this->message);
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
