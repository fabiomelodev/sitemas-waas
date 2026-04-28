<?php

namespace App\Http\Controllers\Webhooks;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class AsaasWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // 1. Log de entrada (Vital para debugar no Sandbox)
        Log::info('Asaas Webhook Recebido', [
            'event' => $request->input('event'),
            'id' => $request->input('payment.id')
        ]);

        // Validação do Token
        if ($request->header('asaas-access-token') !== config('services.asaas.webhook_token')) {
            Log::warning('Tentativa de acesso não autorizado ao Webhook');
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $event = $request->input('event');
            $payment = $request->input('payment');

            // 2. Proteção contra processamento duplicado (Idempotência)
            // Se for um evento de pagamento, verifica se já processamos esse ID de transação antes
            // if (in_array($event, ['PAYMENT_RECEIVED', 'PAYMENT_CONFIRMED'])) {
            //     $alreadyProcessed = \App\Models\Order::where('asaas_payment_id', $payment['id'])->exists();
            //     if ($alreadyProcessed) {
            //         return response()->json(['status' => 'already_processed'], 200);
            //     }
            // }

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

                default:
                    Log::info("Evento ignorado: {$event}");
                    break;
            }

            return response()->json(['status' => 'success'], 200);

        } catch (\Exception $e) {
            // 3. Log de erro catastrófico
            Log::error('Erro ao processar Webhook do Asaas', [
                'mensagem' => $e->getMessage(),
                'payload' => $request->all()
            ]);

            // Retornamos 500 para o Asaas tentar reenviar o webhook depois
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    // Métodos auxiliares para manter o código limpo
    private function handlePaymentConfirmed($payment)
    {
        Log::info('handlePaymentConfirmed');
        // Lógica que já criamos: User::firstOrCreate, Order::create, Notify...
    }

    private function handlePaymentOverdue($payment)
    {
        Log::info('handlePaymentOverdue');
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
