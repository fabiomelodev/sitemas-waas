<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{HomeController, NewPasswordController, SubscriptionController};

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('assinar')->name('subscription.')->group(function () {
    Route::get('/modelo/{template:slug}', [SubscriptionController::class, 'show'])->name('show');

    Route::post('/checkout/{plan:slug}/{template:slug}', [SubscriptionController::class, 'checkout'])->name('checkout');

    Route::get('/sucesso-no-pagamento', [SubscriptionController::class, 'success'])->name('success');
});

Route::controller(NewPasswordController::class)->group(function () {
    Route::get('/reset-password/{token}', 'create')->name('password.reset');

    Route::post('/reset-password', 'store')->name('password.update');
});

if (app()->environment('local') || str_contains(config('services.asaas.url'), 'sandbox')) {

    Route::get('/debug/pay/{paymentId}', function (string $paymentId) {
        $baseUrl = config('services.asaas.url');
        $token = config('services.asaas.token');

        // De acordo com a documentação do Simulador de Vendas:
        // Enviamos o ID da cobrança e o status que queremos simular (CONFIRMED para Cartão/Pix ou RECEIVED para Boleto compensado)
        $response = Illuminate\Support\Facades\Http::withHeaders([
            'access_token' => $token,
        ])->post("{$baseUrl}/sandbox/salesSimulation", [
                    'paymentId' => $paymentId,
                    'status' => 'CONFIRMED'
                ]);

        if ($response->successful()) {
            return response()->json([
                'status' => 'Success',
                'message' => "The sales simulation for payment {$paymentId} was successfully processed.",
                'asaas_response' => $response->json()
            ]);
        }

        return response()->json([
            'status' => 'Error',
            'message' => 'Failed to simulate sales process.',
            'asaas_error' => $response->json()
        ], $response->status());
    })->name('debug.simulate-payment');

}