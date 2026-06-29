<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewPasswordController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('assinar')->name('subscription.')->group(function () {
    Route::get('/modelo/{template:slug}', [SubscriptionController::class, 'show'])->name('show');

    Route::post('/checkout/{plan:slug}/{template:slug}', [SubscriptionController::class, 'checkout'])
        ->middleware('throttle:10,1')
        ->name('checkout');

    Route::get('/sucesso-no-pagamento', [SubscriptionController::class, 'success'])->name('success');
});

Route::controller(NewPasswordController::class)->group(function () {
    Route::get('/reset-password/{token}', 'create')->name('password.reset');

    Route::post('/reset-password', 'store')
        ->middleware('throttle:10,1')
        ->name('password.update');
});

Route::post('/reset-password/reenviar', [NewPasswordController::class, 'resend'])
    ->middleware('throttle:6,1')
    ->name('password.resend');

// if (app()->environment('local')) {

// Route::get('/debug/simulate-webhook/{method}', function (string $method) {
//     // 1. Criamos o JSON exatamente no formato que o Asaas envia no Webhook
//     $mockPayload = [
//         'event' => 'PAYMENT_RECEIVED', // Evento de pagamento recebido
//         'payment' => [
//             'id' => 'pay_mocked_123456',
//             'value' => 150.00,
//             'billingType' => strtoupper($method), // PIX, BOLETO ou CREDIT_CARD
//             'status' => 'RECEIVED',
//             'customer' => [
//                 'name' => 'Cliente Teste Mogi',
//                 'email' => 'cliente_teste_mogi@email.com',
//                 'phone' => '(11) 99999-9999', // O telefone que você quer testar salvando no User
//             ]
//         ]
//     ];

//     // 2. Fazemos uma requisição interna simulando o disparo do Asaas para o seu Controller
//     // Certifique-se de ajustar o nome da rota do seu webhook se for diferente de 'asaas.webhook'
//     $response = Illuminate\Support\Facades\Http::post(route('asaas.webhook'), $mockPayload);

//     return response()->json([
//         'message' => "Simulação de Webhook para [{$method}] disparada com sucesso!",
//         'webhook_response_status' => $response->status(),
//         'webhook_response_body' => $response->json()
//     ]);
// });

// }
