<?php

use App\Http\Controllers\Webhooks\AsaasWebhookController;
use Illuminate\Support\Facades\Route;

Route::post('/webhooks/asaas', [AsaasWebhookController::class, 'handle']);