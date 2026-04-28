<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{HomeController, SubscriptionController};

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('assinar/{template:slug}', [SubscriptionController::class, 'show'])->name('subscription.show');

Route::get('sucesso', [SubscriptionController::class, 'create'])->name('subscription.create');

Route::post('sucesso', [SubscriptionController::class, 'store'])->name('subscription.store');

Route::get('sucesso-3', fn() => view('pages.success'));
