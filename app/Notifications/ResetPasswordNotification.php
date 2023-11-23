<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\HtmlString;

class ResetPasswordNotification extends Notification
{
    use Queueable;


    public function __construct(public string $token)
    {
        //
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(Lang::get('Reset Password Notification'))
            ->greeting(Lang::get('Hello') . ' '  . $notifiable->name . '!')
            ->line("You are receiving this email because we received a password reset request for your account.")
            ->action(Lang::get('Reset Password Now'), $this->resetUrl($notifiable))
            ->line(Lang::get('If you did not request a password reset, no further action is required. However, For extra security, it is still a good idea to update your password.'))
            ->salutation(new HtmlString("Best regards,<br>Gendil Ho"));
    }

    protected function resetUrl(mixed $notifiable): string
    {
        return url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));
    }
}
