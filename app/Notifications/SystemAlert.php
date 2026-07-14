<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class SystemAlert extends Notification
{
    use Queueable;

    protected $title;
    protected $message;
    protected $icon;
    protected $iconColor;

    /**
     * Create a new notification instance.
     */
    public function __construct($title, $message, $icon = 'bell', $iconColor = 'primary')
    {
        $this->title = $title;
        $this->message = $message;
        $this->icon = $icon;
        $this->iconColor = $iconColor;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'icon' => $this->icon,
            'iconColor' => $this->iconColor,
        ];
    }
}
