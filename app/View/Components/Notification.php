<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Notification extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->notifications = auth()->user()->unreadNotifications ?? [];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $notifications = $this->notifications;

        return view('components.notification', [
            'notifications' => $notifications
        ]);
    }
}
