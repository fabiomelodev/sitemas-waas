<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccessPanel extends Notification implements ShouldQueue
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
            ->subject('✅ Nova assinatura ativa — Sitemas')
            ->greeting('Olá, '.$notifiable->name.'!')
            ->line('Recebemos a confirmação do seu pagamento e sua nova assinatura já está ativa.')
            ->line('Acesse o painel com seu e-mail e senha para acompanhar suas assinaturas.')
            ->action('Acessar o painel', route('filament.client.auth.login'))
            ->line('Esqueceu a senha? Use a opção "Esqueci minha senha" na tela de login.');
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [];
    }
}
