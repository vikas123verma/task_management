<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskDeadlineApprochingNotification extends Notification implements ShouldQueue
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
                    ->line('Task dealine approching')
                    ->action('View Task', url('/tasks/' . $this->task->uuid))
                    ->line('Title: ' . $this->task->title)
                    ->line('Deadline: ' . $this->task->deadline);
    }

    public function toArray($notifiable)
    {
        return [
        ];
    }
}
