<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SystemNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Título da notificação
     *
     * @var string
     */
    protected $title;

    /**
     * Mensagem da notificação
     *
     * @var string
     */
    protected $message;

    /**
     * Tipo da notificação (info, warning, danger, etc)
     *
     * @var string
     */
    protected $type;

    /**
     * URL para redirecionar quando a notificação for clicada
     *
     * @var string|null
     */
    protected $url;

    /**
     * Create a new notification instance.
     *
     * @param string $title
     * @param string $message
     * @param string $type
     * @param string|null $url
     * @return void
     */
    public function __construct($title, $message, $type = 'info', $url = null)
    {
        $this->title = $title;
        $this->message = $message;
        $this->type = $type;
        $this->url = $url;
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
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'type' => $this->type,
            'url' => $this->url,
        ];
    }
} 