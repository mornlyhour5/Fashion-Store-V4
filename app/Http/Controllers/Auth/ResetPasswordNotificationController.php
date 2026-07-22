<?php

// namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
// use \Illuminate\Notifications\Messages\MailMessage;

// // use Illuminate\Http\Request;
// // use Illuminate\Notifications\Notification;


// class ResetPasswordNotificationController extends Controller
// {
//     // public function toMail($notifiable): MailMessage
//     // {
//     //     $url = config('app.frontend_url') . '/reset-password?token=' . $this->token . '&email=' . urlencode($notifiable->email);

//     //     return (new MailMessage)
//     //         ->subject('Reset Password Notification')
//     //         ->line('You are receiving this email because we received a password reset request for your account.')
//     //         ->action('Reset Password', $url)
//     //         ->line('This password reset link will expire in ' . config('auth.passwords.users.expire') . ' minutes.')
//     //         ->line('If you did not request a password reset, no further action is required.');
//     // }


//     public string $token;

//     public function __construct(string $token)
//     {
//         $this->token = $token;
//     }

//     public function via(object $notifiable): array
//     {
//         return ['mail'];
//     }

//     public function toMail(object $notifiable): MailMessage
//     {
//         $url = config('app.frontend_url') . '/reset-password?token=' . $this->token . '&email=' . urlencode($notifiable->email);

//         return (new MailMessage)
//             ->subject('Reset Password Notification')
//             ->line('You received this email because we got a password reset request for your account.')
//             ->action('Reset Password', $url)
//             ->line('This link will expire in ' . config('auth.passwords.users.expire') . ' minutes.')
//             ->line('If you did not request a reset, no further action is required.');
//     }
// }

