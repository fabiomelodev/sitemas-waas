<?php

namespace App\Providers;

use App\Events\PaymentReceived;
use App\Events\SubscriptionActivated;
use App\Events\SubscriptionCanceled;
use App\Events\SubscriptionPaymentOverdue;
use App\Listeners\SendCancellationNotification;
use App\Listeners\SendOverdueNotification;
use App\Listeners\SendPaymentConfirmedNotification;
use App\Listeners\SendWelcomeNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(SubscriptionActivated::class, SendWelcomeNotification::class);
        Event::listen(PaymentReceived::class, SendPaymentConfirmedNotification::class);
        Event::listen(SubscriptionPaymentOverdue::class, SendOverdueNotification::class);
        Event::listen(SubscriptionCanceled::class, SendCancellationNotification::class);
    }
}
