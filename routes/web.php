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

if (app()->environment('local') || config('services.asaas.url') !== 'https://www.asaas.com/api/v3') {

    Route::get('/debug/pay/{paymentId}', function (string $paymentId) {
        $baseUrl = config('services.asaas.url');
        $token = config('services.asaas.token');

        // Dispara o comando para o Asaas simular que o cliente pagou a cobrança
        $response = Illuminate\Support\Facades\Http::withHeaders([
            'access_token' => $token,
        ])->post("{$baseUrl}/payments/{$paymentId}/simulatePayment");

        if ($response->successful()) {
            return response()->json([
                'status' => 'Success',
                'message' => "The payment {$paymentId} was successfully simulated as PAID.",
                'asaas_response' => $response->json()
            ]);
        }

        return response()->json([
            'status' => 'Error',
            'message' => 'Failed to simulate payment.',
            'asaas_error' => $response->json()
        ], $response->status());
    })->name('debug.simulate-payment');

}