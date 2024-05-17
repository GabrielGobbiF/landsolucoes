<?php

namespace App\Notifications;

use App\Helpers\Helper;
use App\Models\Admin\Wallet;
use App\Models\Obra;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ObraCreatedNotification extends Notification
{
    use Queueable;

    private $obra;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Obra $obra)
    {
        $this->obra = $obra;
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
        return (new MailMessage)
            ->subject('Veiculos')
            ->line($this->message)
            ->action('Visualizar Carro', $this->link);
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
            'message' => $this->obra->razao_social,
            'description' => 'Uma obra foi criada por Marcos Varella',
            'icon' => 'ri-community-line',
            'link' => route('obras.show', $this->obra->id),
        ];
    }
}
