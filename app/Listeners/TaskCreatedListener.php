<?php

namespace App\Listeners;

use App\Events\TaskCreatedEvent;
use App\Models\User;
use App\Notifications\TaskCreatedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class TaskCreatedListener implements ShouldQueue
{
    use Queueable;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TaskCreatedEvent $event)
    {
        $event->user->notify(new TaskCreatedNotification($event->task));
    }
}
