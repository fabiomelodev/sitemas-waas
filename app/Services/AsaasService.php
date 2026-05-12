<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class AsaasService
{
    protected string $token;
    protected string $baseUrl;

    public function __construct()
    {
        $this->token = config('services.asaas.token');
        $this->baseUrl = config('services.asaas.url');
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