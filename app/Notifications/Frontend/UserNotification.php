<?php

namespace App\Notifications\Frontend;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Broadcasting\PrivateChannel;

class UserNotification extends Notification
{
    use Queueable;

    public $data;

    /**
     * Create a new notification instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification that is stored in the database.
     *
     * @param  \Illuminate\Notifications\Notifiable  $notifiable
     * @return array
     */
    public function toDatabase(object $notifiable)
    {
        return array_merge($this->data, [
            'notification_id' => $this->id,
            'created_at' => now()->diffForHumans(),
        ]);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user-notification.' . $this->data['user_id']),
        ];
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'user-notification';
    }

    public function broadcastWith(): array
    {

        return array_merge($this->data, [
            'notification_id' => $this->id,
            'created_at' => now()->diffForHumans(),
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return array_merge($this->data, [
            'notification_id' => $this->id,
            'created_at' => now()->diffForHumans(),
        ]);
    }
}
