<?php

namespace Spatie\ScheduleMonitor\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ScheduledTask;

class ScheduledTaskFactory extends Factory
{
    protected $model = ScheduledTask::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'type' => $this->faker->randomElement(['command', 'shell', 'job', 'closure']),
            'cron_expression' => '* * * * *',
            'grace_time_in_minutes' => 5,
        ];
    }
}
