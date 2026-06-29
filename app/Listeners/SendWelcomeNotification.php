<?php

namespace App\Listeners;

use App\Events\SubscriptionActivated;
use App\Notifications\AccessPanel;
use App\Notifications\WelcomeAndSetPassword;

class SendWelcomeNotification
{
    public function handle(SubscriptionActivated $event): void
    {
        $user = $event->subscription->user;

        if (! $user) {
            return;
        }

        // Primeiro acesso (ainda não definiu a senha) → criar conta / definir senha.
        // Cliente recorrente (já tem senha) → link direto para o login do painel.
        if (is_null($user->password_set_at)) {
            $user->notify(new WelcomeAndSetPassword);
        } else {
            $user->notify(new AccessPanel);
        }
    }
}
