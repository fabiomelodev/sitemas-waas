<?php

namespace App\Listeners;

use App\Events\SubscriptionActivated;
use App\Notifications\WelcomeAndSetPassword;

class SendWelcomeNotification
{
    public function handle(SubscriptionActivated $event): void
    {
        $event->subscription->user?->notify(new WelcomeAndSetPassword);
    }
}
