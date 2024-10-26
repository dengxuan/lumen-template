<?php

namespace App\Models;

use App\Support\Concerns\UsesScheduleMonitoringModels;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Date;

class ScheduledTaskLogItem extends Model
{
    use UsesScheduleMonitoringModels;
    use HasFactory;
    use MassPrunable;

    public $guarded = [];

    public const TYPE_STARTING = 'starting';
    public const TYPE_FINISHED = 'finished';
    public const TYPE_FAILED = 'failed';
    public const TYPE_SKIPPED = 'skipped';

    public $casts = [
        'meta' => 'array',
    ];

    public function monitoredScheduledTask(): BelongsTo
    {
        return $this->belongsTo($this->getMonitoredScheduleTaskModel(), 'monitored_scheduled_task_id');
    }

    public function updateMeta(array $values): self
    {
        $this->update(['meta' => $values]);

        return $this;
    }

    public function prunable()
    {
        $days = config('schedule-monitor.delete_log_items_older_than_days');

        return static::where('created_at', '<=', Date::now()->subDays($days));
    }
}
