<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;
use App\Models\Discussion;

class NewReply extends Notification
{
    use Queueable;
    public $reply;

    /**
     * Create a new notification instance.
     */
    public function __construct($reply)
    {
        $this->reply = $reply;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        $user = User::find($this->reply->user_id);
        $discussion = Discussion::find($this->reply->discussion_id);
        return [
            'name' => $user->name,
            'email' => $user->email,
            'message' => $user->name."Replied to the topic: " . $discussion->title,
            'type' => 3
        ];
    }
}
