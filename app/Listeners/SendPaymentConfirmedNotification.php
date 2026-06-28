<?php

namespace App\Listeners;

use App\Events\PaymentReceived;
use App\Notifications\PaymentConfirmed;

class SendPaymentConfirmedNotification
{
    public function handle(PaymentReceived $event): void
    {
        $event->order->user?->notify(new PaymentConfirmed($event->order));
    }
}
