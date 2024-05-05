<?php

namespace App\Providers;

use App\Events\TaskCreatedEvent;
use App\Listeners\TaskCreatedListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        // Register events and listeners
        Event::listen(TaskCreatedEvent::class, TaskCreatedListener::class);
    }
}
