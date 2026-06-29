<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Password;

class WelcomeAndSetPassword extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        // Gera o token de segurança para o e-mail do usuário
        $token = Password::createToken($notifiable);

        // Link que leva para a tela de "Nova Senha" do seu sistema
        $url = url(route('password.reset', [
            'token' => $token,
            'email' => $notifiable->email,
        ]));

        return (new MailMessage)
            ->subject('🚀 Bem-vindo à Sitemas! Crie sua conta de acesso')
            ->greeting('Olá, '.$notifiable->name.'!')
            ->line('Seu pagamento foi confirmado com sucesso e já reservamos o modelo que você escolheu.')
            ->line('Para acompanhar sua assinatura e configurar seu site, crie sua conta definindo uma senha de acesso ao painel.')
            ->action('Criar minha conta', $url)
            ->line('Este link expirará em 60 minutos por segurança.')
            ->line('Estamos ansiosos para colocar sua empresa online!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
