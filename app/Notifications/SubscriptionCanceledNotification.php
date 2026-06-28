<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionCanceledNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Sua assinatura foi cancelada — Sitemas')
            ->greeting('Olá, '.$notifiable->name.'!')
            ->line('Confirmamos o cancelamento da sua assinatura.')
            ->line('Seu site permanecerá ativo até o fim do período já pago.')
            ->line('Mudou de ideia? Você pode assinar novamente quando quiser.');
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [];
    }
}
