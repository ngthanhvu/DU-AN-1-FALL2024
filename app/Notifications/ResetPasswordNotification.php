<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    protected $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $frontEndUrl = env('FRONTEND_URL');
        $resetPasswordUrl = $frontEndUrl . '/doi-mat-khau?token=' . $this->token . '&email=' . $notifiable->email;
        return (new MailMessage)
            ->line('Bạn nhận được email này vì chúng tôi đã nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn.')
            ->action('Đặt lại mật khẩu', $resetPasswordUrl)
            ->line('Nếu bạn không yêu cầu đặt lại mật khẩu, không cần thực hiện hành động nào khác.');
    }
}
