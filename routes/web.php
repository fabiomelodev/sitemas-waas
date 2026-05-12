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