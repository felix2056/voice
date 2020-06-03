<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class YouHaveNewMail extends Notification
{
    use Queueable;

    protected $mail;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($mail)
    {
        $this->mail = $mail;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = '/dashboard/mail/' .$this->mail['link'];

        return (new MailMessage)
            ->level('success')
            ->from('no-reply@voice.com', 'The Voice')
            ->subject('You Have Mail!')
            ->line('You have received a new mail from ' . $this->mail['sender'])
            ->line($this->mail['body'])
            ->action('Read More', url($url));
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
            'message' => 'You have a new mail from ' . $this->mail['sender'],
            'link' => '/dashboard/mail/' .$this->mail['link'],
            'icon' => 'fa fa-envelope text-aqua'
        ];
    }
}
