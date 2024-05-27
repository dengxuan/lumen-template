<?php

namespace App\Support\ScheduledTasks;

use Illuminate\Console\Scheduling\Event;
use App\Support\ScheduledTasks\Tasks\ClosureTask;
use App\Support\ScheduledTasks\Tasks\CommandTask;
use App\Support\ScheduledTasks\Tasks\JobTask;
use App\Support\ScheduledTasks\Tasks\ShellTask;
use App\Support\ScheduledTasks\Tasks\Task;

class ScheduledTaskFactory
{
    public static function createForEvent(Event $event): Task
    {
        $taskClass = collect([
            ClosureTask::class,
            JobTask::class,
            CommandTask::class,
            ShellTask::class,
        ])
            ->first(fn (string $taskClass) => $taskClass::canHandleEvent($event));

        return new $taskClass($event);
    }
}
