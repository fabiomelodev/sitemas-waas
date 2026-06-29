<?php

namespace App\Services;

use App\Events\PaymentReceived;
use App\Events\SubscriptionActivated;
use App\Events\SubscriptionCanceled;
use App\Events\SubscriptionPaymentOverdue;
use App\Models\Order;
use App\Models\SiteConfig;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    /**
     * Confirma um pagamento recebido/confirmado: ativa a assinatura, registra
     * a ordem e dispara os eventos de domínio. Idempotente.
     *
     * @param  array<string, mixed>  $payment
     */
    public function confirmPayment(array $payment): void
    {
        // Idempotência: o mesmo pagamento nunca é processado duas vezes.
        if (Order::query()->where('asaas_payment_id', $payment['id'])->exists()) {
            return;
        }

        $subscription = $this->findSubscription($payment);

        if (! $subscription) {
            Log::warning('Pagamento confirmado sem assinatura local correspondente', [
                'payment_id' => $payment['id'] ?? null,
                'asaas_subscription_id' => $payment['subscription'] ?? null,
            ]);

            return;
        }

        $firstActivation = $subscription->status !== 'active';

        $order = DB::transaction(function () use ($subscription, $payment) {
            $subscription->update([
                'status' => 'active',
                'expires_at' => now()->addMonth(),
                'canceled_at' => null,
            ]);

            $order = Order::create([
                'user_id' => $subscription->user_id,
                'subscription_id' => $subscription->id,
                'asaas_payment_id' => $payment['id'],
                'amount' => $payment['value'] ?? null,
                'status' => 'completed',
                'payment_method' => $payment['billingType'] ?? null,
                'paid_at' => now(),
            ]);

            // Nome inicial = nome do modelo (ajuda a distinguir os sites quando
            // o cliente tem mais de um). O cliente edita depois para o nome real.
            SiteConfig::updateOrCreate(
                ['subscription_id' => $subscription->id],
                [
                    'company_name' => $subscription->template?->name ?? $subscription->user?->name,
                    'status' => 0,
                    'user_id' => $subscription->user_id,
                ]
            );

            return $order;
        });

        // Eventos fora da transação para não segurar locks durante notificações.
        if ($firstActivation) {
            event(new SubscriptionActivated($subscription));
        }

        event(new PaymentReceived($order));
    }

    /**
     * @param  array<string, mixed>  $payment
     */
    public function markOverdue(array $payment): void
    {
        $subscription = $this->findSubscription($payment);

        if (! $subscription) {
            return;
        }

        $subscription->update(['status' => 'past_due']);

        event(new SubscriptionPaymentOverdue($subscription));
    }

    public function cancelSubscription(?string $asaasSubscriptionId): void
    {
        if (! $asaasSubscriptionId) {
            return;
        }

        $subscription = Subscription::query()
            ->where('asaas_subscription_id', $asaasSubscriptionId)
            ->first();

        if (! $subscription || $subscription->status === 'canceled') {
            return; // idempotente: não recancelar nem reenviar e-mail
        }

        $subscription->update([
            'status' => 'canceled',
            'canceled_at' => now(),
        ]);

        event(new SubscriptionCanceled($subscription));
    }

    /**
     * @param  array<string, mixed>  $payment
     */
    public function refundPayment(array $payment): void
    {
        Order::query()
            ->where('asaas_payment_id', $payment['id'] ?? null)
            ->update(['status' => 'refunded']);
    }

    /**
     * @param  array<string, mixed>  $payment
     */
    private function findSubscription(array $payment): ?Subscription
    {
        if (empty($payment['subscription'])) {
            return null;
        }

        return Subscription::query()
            ->where('asaas_subscription_id', $payment['subscription'])
            ->first();
    }
}
