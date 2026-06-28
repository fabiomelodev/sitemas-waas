<?php

namespace App\Listeners;

use App\Events\SubscriptionPaymentOverdue;
use App\Notifications\PaymentOverdueNotification;

class SendOverdueNotification
{
    public function handle(SubscriptionPaymentOverdue $event): void
    {
        $event->subscription->user?->notify(new PaymentOverdueNotification);
    }
}
