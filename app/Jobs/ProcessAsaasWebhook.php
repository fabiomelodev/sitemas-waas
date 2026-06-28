<?php

namespace App\Jobs;

use App\Services\PaymentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessAsaasWebhook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 5;

    public int $backoff = 30;

    /**
     * @param  array<string, mixed>  $payload
     */
    public function __construct(public array $payload) {}

    public function handle(PaymentService $payments): void
    {
        $event = $this->payload['event'] ?? null;
        $payment = $this->payload['payment'] ?? [];

        switch ($event) {
            case 'PAYMENT_RECEIVED':
            case 'PAYMENT_CONFIRMED':
                $payments->confirmPayment($payment);
                break;

            case 'PAYMENT_OVERDUE':
                $payments->markOverdue($payment);
                break;

            case 'PAYMENT_REFUNDED':
                $payments->refundPayment($payment);
                break;

            case 'SUBSCRIPTION_DELETED':
                $payments->cancelSubscription($payment['subscription'] ?? ($payment['id'] ?? null));
                break;

            default:
                Log::info("Asaas: evento ignorado [{$event}]");
                break;
        }
    }
}
