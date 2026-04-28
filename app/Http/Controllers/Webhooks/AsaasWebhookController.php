<?php

namespace App\Http\Controllers\Webhooks;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class AsaasWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Validação do Token (aquela que fizemos antes)
        if ($request->header('asaas-access-token') !== config('services.asaas.webhook_token')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $event = $request->input('event');
        $payment = $request->input('payment');

        switch ($event) {
            case 'PAYMENT_RECEIVED':
            case 'PAYMENT_CONFIRMED':
                $this->handlePaymentConfirmed($payment);
                break;

            case 'PAYMENT_OVERDUE':
                $this->handlePaymentOverdue($payment);
                break;

            case 'SUBSCRIPTION_DELETED':
                $this->handleSubscriptionDeleted($payment);
                break;

            case 'PAYMENT_REFUNDED':
                $this->handleRefund($payment);
                break;
        }

        return response()->json(['status' => 'success']);
    }

    // Métodos auxiliares para manter o código limpo
    private function handlePaymentConfirmed($payment)
    {
        dd('handlePaymentConfirmed', $payment);
        // Lógica que já criamos: User::firstOrCreate, Order::create, Notify...
    }

    private function handlePaymentOverdue($payment)
    {
        dd('handlePaymentOverdue', $payment);
        // Atualiza status da assinatura para 'past_due' ou 'atrasado'
    }

    private function handleSubscriptionDeleted($payment)
    {
        //
    }

    private function handleRefund($payment)
    {
        //
    }
}
