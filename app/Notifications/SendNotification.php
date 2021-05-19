<?php

namespace App\Notifications;

use App\Helpers\Helper;
use App\Models\Admin\Wallet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendNotification extends Notification
{
    use Queueable;

    private $wallet;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message = '',  $icon = 'fas fa-bell', $link = '', $byAdmin = 'N')
    {
        $this->message = $message;
        $this->icon = $icon;
        $this->link = $link;
        $this->byAdmin = $byAdmin;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [DatabaseChannel::class];
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
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     * 'transfer', 'purchase', 'withdraw', 'received'
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => 'Notificação',
            'description' => $this->message ?? '',
            'icon' => $this->icon,
            'link' => $this->link ?? '',
        ];
    }
}
