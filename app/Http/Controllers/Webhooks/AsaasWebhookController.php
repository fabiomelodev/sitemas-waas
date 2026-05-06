<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Models\{Lead, Order, Plan, SiteConfig, Subscription, User};
use App\Notifications\WelcomeAndSetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Hash, Http, Log};
use Illuminate\Support\Str;

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
            if (in_array($event, ['PAYMENT_RECEIVED', 'PAYMENT_CONFIRMED'])) {
                $alreadyProcessed = Order::query()->where('asaas_payment_id', $payment['id'])->exists();
                if ($alreadyProcessed) {
                    return response()->json(['status' => 'already_processed'], 200);
                }
            }

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
                'asaas_customer_id' => $customerId,
                // Gera uma senha aleatória de 32 caracteres
                'password' => Hash::make(Str::random(32)),
            ]
        );

        // O Asaas costuma enviar o ID do link de pagamento no payload
        $paymentLinkId = $payment['paymentLink'] ?? null;

        $plan = Plan::query()->where('asaas_link_id', $paymentLinkId)->first();

        // Se não encontrar, define um plano padrão para não quebrar o código
        $planId = $plan ? $plan->id : 1;

        $lead = Lead::query()->where('email', $asaasCustomer['email'])->first();

        $templateId = $lead ? $lead->template_id : null;

        // 1. Criar ou atualizar a assinatura
        $subscription = Subscription::updateOrCreate(
            ['user_id' => $user->id],
            [
                'asaas_subscription_id' => $payment['subscription'] ?? null,
                'status' => 'active',
                'plan_id' => $planId, // O ID do plano que você cadastrou no banco
                'template_id' => $templateId,
                'expires_at' => now()->addMonth(), // Ou baseado na data do Asaas
            ]
        );

        // 2. Registrar o pagamento no histórico (Orders)
        Order::create([
            'user_id' => $user->id,
            'subscription_id' => $subscription->id,
            'asaas_payment_id' => $payment['id'],
            'amount' => $payment['value'],
            'status' => 'completed',
            'payment_method' => $payment['billingType'],
            'paid_at' => now(),
        ]);

        SiteConfig::create([
            'company_name' => $asaasCustomer['name'],
            'status' => 0,
            'subscription_id' => $subscription->id,
            'user_id' => $user->id
        ]);

        $user->notify(new WelcomeAndSetPassword());

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
