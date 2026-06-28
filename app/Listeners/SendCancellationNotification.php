<?php

namespace App\Listeners;

use App\Events\SubscriptionCanceled;
use App\Notifications\SubscriptionCanceledNotification;

class SendCancellationNotification
{
    public function handle(SubscriptionCanceled $event): void
    {
        $event->subscription->user?->notify(new SubscriptionCanceledNotification);
    }
}
