<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{HomeController, NewPasswordController, SubscriptionController};
use Illuminate\Support\Facades\Mail;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('assinar/{template:slug}', [SubscriptionController::class, 'show'])->name('subscription.show');

Route::post('assinar/checkout/{plan:slug}/{template:slug}', [SubscriptionController::class, 'checkout'])->name('subscription.checkout');

Route::get('sucesso', [SubscriptionController::class, 'create'])->name('subscription.create');

Route::post('sucesso', [SubscriptionController::class, 'store'])->name('subscription.store');

Route::get('sucesso-3', fn() => view('pages.success'));

// Esta é a rota que você usou na Notificação (password.reset)
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
    ->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->name('password.update');

Route::get('/test-mail', function () {
    Mail::raw('Funcionou!', function ($message) {
        $message->to('seu-email@gmail.com')->subject('Teste Resend');
    });
});
