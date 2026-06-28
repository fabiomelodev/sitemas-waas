<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessAsaasWebhook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AsaasWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $webhookToken = config('services.asaas.env') === 'sandbox'
            ? config('services.asaas.sandbox_webhook_token')
            : config('services.asaas.webhook_token');

        // Nunca logar os tokens em texto puro.
        Log::info('Asaas Webhook Recebido', [
            'event' => $request->input('event'),
            'id' => $request->input('payment.id'),
        ]);

        // Validação do token em tempo constante.
        if (! hash_equals((string) $webhookToken, (string) $request->header('asaas-access-token'))) {
            Log::warning('Tentativa de acesso não autorizado ao Webhook do Asaas');

            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Processamento assíncrono e resiliente: respondemos 200 imediatamente
        // e tratamos o evento na fila (com retries automáticos).
        ProcessAsaasWebhook::dispatch($request->all());

        return response()->json(['status' => 'queued'], 200);
    }
}
