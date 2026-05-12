<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('faqs')->insert([
            [
                'name' => 'O que está incluso na minha assinatura?',
                'description' => 'Sua assinatura é completa: inclui a hospedagem do site em servidores de alta performance,
                        manutenção técnica constante, atualizações de segurança, certificado SSL e suporte humano para
                        ajustes e dúvidas.',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'O site será meu ou da Single Temas?',
                'description' => 'O modelo de assinatura funciona como um aluguel de software (WaaS). Enquanto a assinatura estiver ativa, você tem o direito total de uso. Isso garante que você nunca precise se preocupar com renovação de servidor ou erros técnicos por conta própria.',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Posso usar meu próprio domínio (.com.br)?',
                'description' => 'Sim! No plano Pro, configuramos o seu domínio personalizado. Se você ainda não tem um domínio, nós te orientamos no processo de registro ou cuidamos de tudo para você.',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Como funciona a manutenção do site?',
                'description' => 'Nós cuidamos da "cozinha" técnica: atualizamos o WordPress e plugins, monitoramos a velocidade e realizamos backups diários para que seu negócio nunca pare.',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Existe fidelidade ou multa de cancelamento?',
                'description' => 'Não. Você pode cancelar sua assinatura a qualquer momento através do painel de controle do Asaas ou entrando em contato com nosso suporte, sem qualquer multa oculta.',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
