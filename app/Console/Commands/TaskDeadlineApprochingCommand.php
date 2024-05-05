<?php

namespace App\Console\Commands;

use App\Events\TaskDeadlineApprochingEvent;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Console\Command;

class TaskDeadlineApprochingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:deadline';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $date = Carbon::now()->subDay(1);
        Task::with(['user'])->whereRaw('"' . $date . '" < deadline')
            ->whereNull('is_notified')
            ->chunk(10, function ($tasks) {
                $updateIds = [];
                foreach ($tasks as $task) {
                    event(new TaskDeadlineApprochingEvent($task));
                    $updateIds[] = $task->id;
                }
                Task::whereIn('id', $updateIds)->update([
                    "is_notified" => 1
                ]);
            });
    }
}
