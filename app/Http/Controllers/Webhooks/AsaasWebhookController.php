<?php

namespace App\Http\Controllers\Webhooks;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AsaasWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('Token recebido do Asaas: ' . $request->header('asaas-access-token'));
        Log::info('Token configurado no meu sistema: ' . config('services.asaas.webhook_token'));

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
        $customerId = $payment['customer'];

        // 1. Busca os detalhes do cliente no Asaas via API
        $response = Http::withHeaders([
            'access_token' => config('services.asaas.api_key'),
        ])->get("https://sandbox.asaas.com/api/v3/customers/{$customerId}");

        if ($response->failed()) {
            Log::error("Falha ao buscar cliente {$customerId} no Asaas");
            return;
        }

        $asaasCustomer = $response->json();

        // 2. Agora você tem o e-mail e o nome reais!
        $user = User::firstOrCreate(
            ['email' => $asaasCustomer['email']],
            [
                'name' => $asaasCustomer['name'],
                'phone' => $asaasCustomer['phone'] ?? null,
                'asaas_customer_id' => $customerId,
            ]
        );

        // 3. Vincula a assinatura e cria a ordem
        // ... restante da sua lógica
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
