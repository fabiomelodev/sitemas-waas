<?php

namespace App\Notifications;

use App\Helpers\FormatCurrency;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentConfirmed extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Order $order) {}

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
            ->subject('✅ Pagamento confirmado — Sitemas')
            ->greeting('Olá, '.$notifiable->name.'!')
            ->line('Recebemos a confirmação do seu pagamento de '.FormatCurrency::getFormatCurrency($this->order->amount).'.')
            ->line('Sua assinatura está ativa e seu site já entrou na fila de configuração.')
            ->line('Obrigado por confiar na Sitemas!');
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'amount' => $this->order->amount,
        ];
    }
}
