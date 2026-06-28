<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AsaasService
{
    protected string $token;

    protected string $baseUrl;

    public function __construct()
    {
        $isSandbox = config('services.asaas.env') === 'sandbox';

        $this->token = $isSandbox ? config('services.asaas.sandbox_token') : config('services.asaas.token');
        $this->baseUrl = rtrim($isSandbox ? config('services.asaas.sandbox_url') : config('services.asaas.url'), '/');
    }

    protected function client(): PendingRequest
    {
        return Http::withHeaders(['access_token' => $this->token])
            ->acceptJson()
            ->timeout(20)
            ->baseUrl($this->baseUrl);
    }

    /**
     * Cria um cliente no Asaas. Requer name e cpfCnpj.
     *
     * @return array<string, mixed>|null
     */
    public function createCustomer(array $data): ?array
    {
        $response = $this->client()->post('/customers', [
            'name' => $data['name'],
            'email' => $data['email'] ?? null,
            'mobilePhone' => $this->onlyDigits($data['phone'] ?? null),
            'cpfCnpj' => $this->onlyDigits($data['cpf_cnpj'] ?? null),
        ]);

        if ($response->failed()) {
            Log::error('Asaas: falha ao criar cliente', ['body' => $response->json()]);

            return null;
        }

        return $response->json();
    }

    /**
     * Busca um cliente no Asaas usando a URL base configurada (sandbox/produção).
     *
     * @return array<string, mixed>|null
     */
    public function getCustomer(string $customerId): ?array
    {
        $response = $this->client()->get("/customers/{$customerId}");

        return $response->successful() ? $response->json() : null;
    }

    /**
     * Cria uma assinatura recorrente no Asaas vinculada a um cliente.
     * billingType UNDEFINED deixa o cliente escolher Pix, Boleto ou Cartão
     * na página de checkout hospedada do Asaas.
     *
     * @return array<string, mixed>|null
     */
    public function createSubscription(array $data): ?array
    {
        $response = $this->client()->post('/subscriptions', [
            'customer' => $data['customer'],
            'billingType' => $data['billingType'] ?? 'UNDEFINED',
            'value' => $data['value'],
            'nextDueDate' => $data['nextDueDate'],
            'cycle' => $data['cycle'] ?? 'MONTHLY',
            'description' => $data['description'] ?? null,
            'externalReference' => $data['externalReference'] ?? null,
        ]);

        if ($response->failed()) {
            Log::error('Asaas: falha ao criar assinatura', ['body' => $response->json()]);

            return null;
        }

        return $response->json();
    }

    /**
     * Retorna a URL de checkout (invoiceUrl) da primeira cobrança de uma
     * assinatura, para onde o cliente é redirecionado para pagar.
     */
    public function getSubscriptionCheckoutUrl(string $subscriptionId): ?string
    {
        $response = $this->client()->get("/subscriptions/{$subscriptionId}/payments");

        if ($response->failed()) {
            return null;
        }

        return $response->json('data.0.invoiceUrl');
    }

    public function cancelSubscription(string $subscriptionId): bool
    {
        return $this->client()->delete("/subscriptions/{$subscriptionId}")->successful();
    }

    protected function onlyDigits(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        return preg_replace('/\D/', '', $value);
    }
}
