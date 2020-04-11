<?php

namespace FederalSt\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;


class MyResetPasswordNotification extends ResetPassword
{

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->error()
            ->greeting(trans('email.greeting'))
            ->line( trans('email.motivo'))
            ->action( 'Reset Password', url(config('app.url').route('password.reset', $this->token, false)))
            ->line(trans('email.notaction'))
            ->subject(trans('email.subject'))
            ->salutation(trans('email.salutation'));
    }

}
