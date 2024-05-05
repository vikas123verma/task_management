<?php

namespace App\Listeners;

use App\Events\TaskDeadlineApprochingEvent;
use App\Notifications\TaskDeadlineApprochingNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class TaskDeadlineApprochingListener implements ShouldQueue
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
    public function handle(TaskDeadlineApprochingEvent $event)
    {
        $event->task->user->notify(new TaskDeadlineApprochingNotification($event->task));
    }
}
