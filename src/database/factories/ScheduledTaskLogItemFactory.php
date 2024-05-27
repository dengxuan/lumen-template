<?php

namespace App\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ScheduledTask;
use App\Models\ScheduledTaskLogItem;

class ScheduledTaskLogItemFactory extends Factory
{
    protected $model = ScheduledTaskLogItem::class;

    public function definition(): array
    {
        return [
            'scheduled_task_id' => ScheduledTask::factory(),
            'type' => $this->faker->randomElement([
                ScheduledTaskLogItem::TYPE_STARTING,
                ScheduledTaskLogItem::TYPE_FINISHED,
                ScheduledTaskLogItem::TYPE_SKIPPED,
            ]),
            'meta' => [],
        ];
    }

    public function configure()
    {
        return $this->afterMaking(function(ScheduledTaskLogItem $logItem) {
            $scheduledTask = $logItem->monitoredScheduledTask;
            $scheduledTask->ping_url = 'https://ping.ohdear.app';
            $scheduledTask->save();

            return $logItem;
        });
    }
}
