<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Template;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use RuntimeException;

class SubscriptionService
{
    public function __construct(private readonly AsaasService $asaas) {}

    /**
     * Inicia uma assinatura: cria o cliente local e no Asaas, cria a
     * assinatura recorrente no Asaas, persiste localmente como "pending" e
     * devolve a URL de checkout para onde o usuário deve ser redirecionado.
     *
     * @param  array{name:string,email:string,phone:string,cpf_cnpj:string}  $data
     */
    public function startSubscription(array $data, Plan $plan, Template $template): string
    {
        $user = $this->resolveUser($data);

        $customerId = $this->ensureAsaasCustomer($user, $data);

        $asaasSubscription = $this->asaas->createSubscription([
            'customer' => $customerId,
            'billingType' => 'UNDEFINED',
            'value' => (float) $plan->price,
            'nextDueDate' => now()->format('Y-m-d'),
            'cycle' => 'MONTHLY',
            'description' => "Plano {$plan->name} - Modelo {$template->name}",
            'externalReference' => "plan:{$plan->id}|template:{$template->id}",
            'callback' => [
                'successUrl' => route('subscription.success'),
                'autoRedirect' => true,
            ],
        ]);

        if (! isset($asaasSubscription['id'])) {
            throw new RuntimeException('Não foi possível criar a assinatura no Asaas.');
        }

        DB::transaction(function () use ($user, $plan, $template, $asaasSubscription) {
            Subscription::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'asaas_subscription_id' => $asaasSubscription['id'],
                    'status' => 'pending',
                    'plan_id' => $plan->id,
                    'template_id' => $template->id,
                    'expires_at' => null,
                    'canceled_at' => null,
                ]
            );
        });

        $checkoutUrl = $this->asaas->getSubscriptionCheckoutUrl($asaasSubscription['id']);

        if (! $checkoutUrl) {
            Log::warning('Assinatura criada mas sem URL de checkout', [
                'asaas_subscription_id' => $asaasSubscription['id'],
            ]);

            // Fallback: invoiceUrl pode vir no próprio objeto da assinatura.
            $checkoutUrl = $asaasSubscription['invoiceUrl'] ?? null;
        }

        if (! $checkoutUrl) {
            throw new RuntimeException('Assinatura criada, mas não foi possível obter a URL de pagamento.');
        }

        return $checkoutUrl;
    }

    private function resolveUser(array $data): User
    {
        $user = User::firstOrNew(['email' => $data['email']]);

        $user->fill([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'cpf_cnpj' => $data['cpf_cnpj'],
        ]);

        // Define uma senha aleatória apenas para usuários novos; nunca
        // sobrescreve a senha de quem já definiu a sua.
        if (! $user->exists) {
            $user->password = Hash::make(Str::random(40));
            $user->is_admin = false;
        }

        $user->save();

        return $user;
    }

    private function ensureAsaasCustomer(User $user, array $data): string
    {
        if ($user->asaas_customer_id) {
            return $user->asaas_customer_id;
        }

        $customer = $this->asaas->createCustomer([
            'name' => $data['name'],
            'email' => $user->email,
            'phone' => $data['phone'],
            'cpf_cnpj' => $data['cpf_cnpj'],
        ]);

        if (! isset($customer['id'])) {
            throw new RuntimeException('Não foi possível criar o cliente no Asaas.');
        }

        $user->update(['asaas_customer_id' => $customer['id']]);

        return $customer['id'];
    }
}
