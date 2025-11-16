<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

class CustomVerifyEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
    // Ambil nim dari relasi mahasiswa
        $username = $notifiable->username ?? '(tidak tersedia)';
        $verifyUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
        ->subject('Akun Anda Telah Dibuat - Verifikasi & Informasi Login')
        ->greeting('Halo ' . $notifiable->name . '!')
        ->line('Akun Anda telah berhasil dibuat pada sistem SIM-KLINIK.')
        ->line('Berikut adalah informasi login Anda:')
        ->line('**Username:** ' . $username)
        ->line('**Password Sementara:** ' . $username)
        ->line('Silakan klik tombol di bawah ini untuk memverifikasi akun Anda.')
        ->action('Verifikasi Akun', $verifyUrl)
        ->line('⚠️ Demi keamanan, segera ubah password Anda setelah berhasil login melalui menu Profile.')
        ->salutation('Terima kasih, SIM-KLINIK');
    }

    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())]
        );
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
