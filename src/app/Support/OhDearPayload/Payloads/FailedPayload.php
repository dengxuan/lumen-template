<?php

namespace App\Support\OhDearPayload\Payloads;

use Illuminate\Support\Arr;
use App\Models\ScheduledTaskLogItem;

class FailedPayload extends Payload
{
    public static function canHandle(ScheduledTaskLogItem $logItem): bool
    {
        return $logItem->type === ScheduledTaskLogItem::TYPE_FAILED;
    }

    public function url()
    {
        return "{$this->baseUrl()}/failed";
    }

    public function data(): array
    {
        return Arr::only($this->logItem->meta ?? [], [
            'failure_message',
        ]);
    }
}
