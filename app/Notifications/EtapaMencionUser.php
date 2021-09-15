<?php

namespace App\Notifications;

use App\Helpers\Helper;
use App\Models\Admin\Wallet;
use App\Models\ObraEtapa;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EtapaMencionUser extends Notification
{
    use Queueable;

    private $etapa;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ObraEtapa $etapa)
    {
        $this->etapa = $etapa;
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
            'message' => $this->etapa->nome,
            'description' => 'Você foi mencionando em uma etapa',
            'icon' => 'ri-community-line',
            'link' => route('obras.show', [$this->etapa->id_obra, 'etp=' . $this->etapa->id]),
        ];
    }
}
