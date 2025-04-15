<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\SystemNotification;

class NotificationsExampleService
{
    /**
     * Enviar uma notificação para um usuário específico
     *
     * @param User $user
     * @param string $title
     * @param string $message
     * @param string $type
     * @param string|null $url
     * @return void
     */
    public function notifyUser(User $user, $title, $message, $type = 'info', $url = null)
    {
        $notification = new SystemNotification($title, $message, $type, $url);
        $user->notify($notification);
    }

    /**
     * Enviar uma notificação para vários usuários
     *
     * @param array $userIds
     * @param string $title
     * @param string $message
     * @param string $type
     * @param string|null $url
     * @return void
     */
    public function notifyUsers(array $userIds, $title, $message, $type = 'info', $url = null)
    {
        $users = User::whereIn('id', $userIds)->get();
        $notification = new SystemNotification($title, $message, $type, $url);
        
        foreach ($users as $user) {
            $user->notify($notification);
        }
    }

    /**
     * Enviar uma notificação para todos os usuários
     *
     * @param string $title
     * @param string $message
     * @param string $type
     * @param string|null $url
     * @return void
     */
    public function notifyAllUsers($title, $message, $type = 'info', $url = null)
    {
        $users = User::all();
        $notification = new SystemNotification($title, $message, $type, $url);
        
        foreach ($users as $user) {
            $user->notify($notification);
        }
    }
    
    /**
     * Exemplos de uso:
     * 
     * // Para notificar um usuário
     * $service = new NotificationsExampleService();
     * $service->notifyUser($user, 'Bem-vindo!', 'Seja bem-vindo ao sistema', 'info', '/dashboard');
     * 
     * // Para notificar vários usuários
     * $service->notifyUsers([1, 2, 3], 'Nova funcionalidade', 'Conheça nossa nova funcionalidade!', 'info');
     * 
     * // Para notificar todos os usuários
     * $service->notifyAllUsers('Manutenção programada', 'O sistema ficará indisponível por 1 hora', 'warning');
     */
} 