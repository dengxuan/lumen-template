<?php

namespace App\Support\OhDearPayload\Payloads;

use App\Models\ScheduledTaskLogItem;

abstract class Payload
{
    protected ScheduledTaskLogItem $logItem;

    abstract public static function canHandle(ScheduledTaskLogItem $logItem): bool;

    public function __construct(ScheduledTaskLogItem $logItem)
    {
        $this->logItem = $logItem;
    }

    abstract public function url();

    abstract public function data();

    protected function baseUrl(): string
    {
        return $this->logItem->monitoredScheduledTask->ping_url;
    }
}
