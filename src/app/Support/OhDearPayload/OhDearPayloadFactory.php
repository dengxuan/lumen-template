<?php

namespace App\Support\OhDearPayload;

use App\Models\ScheduledTaskLogItem;
use App\Support\OhDearPayload\Payloads\FailedPayload;
use App\Support\OhDearPayload\Payloads\FinishedPayload;
use App\Support\OhDearPayload\Payloads\Payload;
use App\Support\OhDearPayload\Payloads\StartingPayload;

class OhDearPayloadFactory
{
    public static function createForLogItem(ScheduledTaskLogItem $logItem): ?Payload
    {
        $payloadClasses = [
            StartingPayload::class,
            FailedPayload::class,
            FinishedPayload::class,
        ];

        $payloadClass = collect($payloadClasses)
            ->first(fn (string $payloadClass) => $payloadClass::canHandle($logItem));

        if (! $payloadClass) {
            return null;
        }

        return new $payloadClass($logItem);
    }
}
