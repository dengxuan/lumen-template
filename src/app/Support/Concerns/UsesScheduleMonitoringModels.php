<?php

namespace App\Support\Concerns;

use function app;
use App\Models\ScheduledTask;
use App\Models\ScheduledTaskLogItem;

trait UsesScheduleMonitoringModels
{
    public function getMonitoredScheduleTaskModel(): ScheduledTask
    {
        return app(ScheduledTask::class);
    }

    public function getMonitoredScheduleTaskLogItemModel(): ScheduledTaskLogItem
    {
        return app(ScheduledTaskLogItem::class);
    }
}
