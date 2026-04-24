<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{HomeController, SubscriptionController};

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('assinar/{template:slug}', [SubscriptionController::class, 'show'])->name('subscription.show');