<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\OnlineExaminationCredential;

class ExamSignUpVerificationNotification extends Notification
{
    use Queueable;

    public $client;

    /**
     * Create a new notification instance.
     */
    public function __construct(OnlineExaminationCredential $client)
    {
        $this->client = $client;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url("/email-verify/{$this->client->verification_token}");

        return (new MailMessage())
                    ->greeting('Dear ' . $this->client['name'].',')
                    ->subject('Confirmation Mail from '.env('APP_NAME'))        
                    ->line('This email is sent to verify your account.')
                    ->action('Click here to Activate', $url)
                    ->line('Thank you for being our partner.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message'=>'Welcome '.$this->client['name'].' to '.env('APP_NAME'),
            'url'=>''
        ];
    }
}
