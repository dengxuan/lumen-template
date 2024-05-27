<?php

namespace App\Jobs;

use DateTime;
use App\Models\ScheduledTaskLogItem;
use App\Support\OhDearPayload\OhDearPayloadFactory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Date;

class PingOhDearJob implements ShouldQueue
{
    public $deleteWhenMissingModels = true;

    use InteractsWithQueue, Queueable, SerializesModels;

    public ScheduledTaskLogItem $logItem;

    public function __construct(ScheduledTaskLogItem $logItem)
    {
        $this->logItem = $logItem;

        if ($queue = config('schedule-monitor.oh_dear.queue')) {
            $this->onQueue($queue);
        }
    }

    public function handle()
    {
        if (! $payload = OhDearPayloadFactory::createForLogItem($this->logItem)) {
            return;
        }

        $response = Http::retry(3, 10 * 1000)->post($payload->url(), $payload->data());
        $response->throw();

        $this->logItem->monitoredScheduledTask->update(['last_pinged_at' => Date::now()]);
    }

    public function retryUntil(): DateTime
    {
        return Date::now()->addMinutes(config('schedule-monitor.oh_dear.retry_job_for_minutes', 10))->toDateTime();
    }
}
