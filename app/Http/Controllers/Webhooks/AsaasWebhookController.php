<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Models\{Lead, Order, Plan, SiteConfig, Subscription, User};
use App\Notifications\WelcomeAndSetPassword;
use App\Services\AsaasService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Hash, Log};
use Illuminate\Support\Str;

class AsaasWebhookController extends Controller
{
    public function __construct(private readonly AsaasService $asaas) {}

    public function handle(Request $request)
    {
        $webhookToken = config('services.asaas.env') == 'sandbox' ? config('services.asaas.sandbox_webhook_token') : config('services.asaas.webhook_token');

        // 1. Log de entrada (Vital para debugar no Sandbox).
        // ATENÇÃO: nunca logar os tokens em texto puro.
        Log::info('Asaas Webhook Recebido', [
            'event' => $request->input('event'),
            'id' => $request->input('payment.id')
        ]);

        // Validação do Token
        if (! hash_equals((string) $webhookToken, (string) $request->header('asaas-access-token'))) {
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

        // 1. Busca os detalhes do cliente no Asaas via API (URL configurada por ambiente).
        $asaasCustomer = $this->asaas->getCustomer($customerId);

        if (! $asaasCustomer) {
            Log::error("Falha ao buscar cliente {$customerId} no Asaas");
            return;
        }

        $lead = Lead::query()->where('email', $asaasCustomer['email'])->first();

        if (User::where('email', $asaasCustomer['email'])->exists()) {
            $user = User::where('email', $asaasCustomer['email'])->first();
        } else {
            $user = User::updateOrCreate(
                ['email' => $asaasCustomer['email']],
                [
                    'name' => $asaasCustomer['name'],
                    'phone' => $lead?->phone,
                    'asaas_customer_id' => $asaasCustomer['id'],
                    // Gera uma senha aleatória de 32 caracteres
                    'password' => Hash::make(Str::random(32)),
                ]
            );

            $user->notify(new WelcomeAndSetPassword());
        }

        // 2. Resolve o plano contratado.
        // Fonte primária: o plano que o lead escolheu no checkout.
        // Fallback: match pelo ID do link de pagamento do Asaas.
        $planId = $lead?->plan_id
            ?? Plan::query()->where('asaas_link_id', $payment['paymentLink'] ?? null)->value('id');

        if (! $planId) {
            Log::warning('Pagamento confirmado sem plano identificável', [
                'payment_id' => $payment['id'],
                'email' => $asaasCustomer['email'],
            ]);
        }

        $templateId = $lead?->template_id;

        // 3. Criar ou atualizar a assinatura
        $subscription = Subscription::updateOrCreate(
            ['user_id' => $user->id],
            [
                'asaas_subscription_id' => $payment['subscription'] ?? null,
                'status' => 'active',
                'plan_id' => $planId,
                'template_id' => $templateId,
                'expires_at' => now()->addMonth(), // Ou baseado na data do Asaas
            ]
        );

        // 4. Registrar o pagamento no histórico (Orders)
        Order::create([
            'user_id' => $user->id,
            'subscription_id' => $subscription->id,
            'asaas_payment_id' => $payment['id'],
            'amount' => $payment['value'],
            'status' => 'completed',
            'payment_method' => $payment['billingType'],
            'paid_at' => now(),
        ]);

        // 5. Garante um único SiteConfig por assinatura (evita duplicar a cada
        // pagamento mensal recorrente).
        SiteConfig::updateOrCreate(
            ['subscription_id' => $subscription->id],
            [
                'company_name' => $asaasCustomer['name'],
                'status' => 0,
                'user_id' => $user->id,
            ]
        );
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
