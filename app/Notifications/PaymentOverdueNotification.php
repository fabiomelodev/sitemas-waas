<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentOverdueNotification extends Notification implements ShouldQueue
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
            ->subject('⚠️ Pagamento em atraso — Sitemas')
            ->greeting('Olá, '.$notifiable->name.'!')
            ->line('Identificamos que a cobrança da sua assinatura está em atraso.')
            ->line('Para manter seu site no ar sem interrupções, regularize o pagamento o quanto antes.')
            ->line('Se você já pagou, desconsidere este aviso.');
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [];
    }
}
