<?php

namespace App\Support\OhDearPayload\Payloads;

use App\Models\ScheduledTaskLogItem;

class StartingPayload extends Payload
{
    public static function canHandle(ScheduledTaskLogItem $logItem): bool
    {
        return $logItem->type === ScheduledTaskLogItem::TYPE_STARTING;
    }

    public function url()
    {
        return "{$this->baseUrl()}/starting";
    }

    public function data(): array
    {
        return [];
    }
}
