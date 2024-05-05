<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskStatusChangeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $task;

    public function __construct($task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Task status has been changed to '.$this->task->status)
                    ->action('View Task', url('/tasks/' . $this->task->uuid))
                    ->line('Title: ' . $this->task->title);
    }

    public function toArray($notifiable)
    {
        return [
        ];
    }
}
