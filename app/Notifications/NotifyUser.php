<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyUser extends Notification
{
    use Queueable;

    /**
     * The attributes that is email subject.
     *
     * @var string
     */
    private $subject;
    /**
     * The attributes that is email body.
     *
     * @var string
     */
    private $message;
    /**
     * The attributes that is additional array of string to put into email.
     *
     * @var array
     */
    private $data;
    /**
     * Create a new notification instance.
     *
     * @param string $subject
     * @param string $message
     * @param array $data
     * @return void
     */
    public function __construct(string $subject = '', string $message = '', array $data = [])
    {
        $this->subject = $subject;
        $this->message = $message;
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable):array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable):object
    {
        return (new MailMessage)
                    ->subject($this->subject)
                    ->markdown('emails.notify_user',
                        [
                            'message' => $this->message,
                            'data' => $this->data
                        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable):array
    {
        return [
            'data' => $this->data
        ];
    }
}
