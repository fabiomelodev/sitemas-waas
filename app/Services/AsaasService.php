<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class AsaasService
{
    protected string $token;
    protected string $baseUrl;

    public function __construct()
    {
        $this->token = config('services.asaas.env') == 'sandbox' ? config('services.asaas.sandbox_token') : config('services.asaas.token');
        $this->baseUrl = config('services.asaas.env') == 'sandbox' ? config('services.asaas.sandbox_url') : config('services.asaas.url');
    }

    /**
     * Busca os dados de um cliente no Asaas usando a URL base configurada
     * (sandbox ou produção). Antes esta chamada estava com a URL de sandbox
     * fixa no controller do webhook, o que quebrava em produção.
     */
    public function getCustomer(string $customerId): ?array
    {
        $response = Http::withHeaders([
            'access_token' => $this->token,
        ])->get("{$this->baseUrl}/customers/{$customerId}");

        if ($response->failed()) {
            return null;
        }

        return $response->json();
    }

    public function createPaymentLink(string $name, float $value)
    {
        // Envia a requisição para o endpoint de paymentLinks do Asaas
        $response = Http::withHeaders([
            'access_token' => $this->token,
        ])->post("{$this->baseUrl}/paymentLinks", [
                    'name' => $name,
                    'value' => $value,
                    'billingType' => 'UNDEFINED', // Permite todas as formas de pagamento
                    'chargeType' => 'RECURRENT',  // Define como assinatura/recorrente
                    'dueDateLimitDays' => 5,
                    'callback' => [
                        'successUrl' => route('subscription.success'), // Rota definida no Laravel
                        'autoRedirect' => true // Força o redirecionamento automático
                    ]
                ]);

        return $response->json();
    }
}