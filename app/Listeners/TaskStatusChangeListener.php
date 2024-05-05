<?php

namespace App\Listeners;

use App\Events\TaskStatusChangeEvent;
use App\Models\User;
use App\Notifications\TaskStatusChangeNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class TaskStatusChangeListener implements ShouldQueue
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
    public function handle(TaskStatusChangeEvent $event)
    {
        $event->user->notify(new TaskStatusChangeNotification($event->task));
    }
}
