<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\HtmlString;

class EmailVerificationNotification extends BaseVerifyEmail
{
    use Queueable;


    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
        }

        return $this->buildMailMessage($verificationUrl);
    }

    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->subject(Lang::get('Email Verification'))
            ->greeting(Lang::get('Hello!'))
            ->line(Lang::get('Please click the button below to verify your email address.'))
            ->action(Lang::get('Verify Email Now'), $url)
            ->line(Lang::get('Prior to resuming use of the application, we encourage you to confirm your email registration. However, If you are uncertain whether this email is registered in the application, you may disregard this message.'))
            ->salutation(new HtmlString("Best regards,<br>Gendil Ho"));
    }
}
