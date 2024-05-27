<?php

namespace App\Support\OhDearPayload\Payloads;

use Illuminate\Support\Arr;
use App\Models\ScheduledTaskLogItem;

class FinishedPayload extends Payload
{
    public static function canHandle(ScheduledTaskLogItem $logItem): bool
    {
        return $logItem->type === ScheduledTaskLogItem::TYPE_FINISHED;
    }

    public function url()
    {
        return "{$this->baseUrl()}/finished";
    }

    public function data(): array
    {
        return Arr::only($this->logItem->meta ?? [], [
            ...(config('schedule-monitor.oh_dear.send_starting_ping') ? [] : ['runtime']),
            'exit_code',
            'memory',
        ]);
    }
}
