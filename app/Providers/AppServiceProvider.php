<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * Os listeners em app/Listeners são registrados automaticamente pela
     * auto-descoberta do Laravel (cada um com handle(Event $event) tipado).
     * Não registrar aqui também, senão as notificações disparam em dobro.
     */
    public function boot(): void
    {
        //
    }
}
