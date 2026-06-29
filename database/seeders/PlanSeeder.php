<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('plans')->insert([
            [
                'name' => 'Plano Start',
                'slug' => 'plano-start',
                'description' => 'Ideal para validação e presença rápida.',
                'price' => 99,
                'features' => json_encode(
                    [
                        [
                            'name' => '1 Modelo Essencial',
                            'status' => 1,
                        ],

                        [
                            'name' => 'Hospedagem de Alta Performance Inclusa',
                            'status' => 1,
                        ],

                        [
                            'name' => 'Suporte via WhatsApp',
                            'status' => 1,
                        ],

                        [
                            'name' => 'Manutenção Técnica & Atualizações',
                            'status' => 1,
                        ],

                        [
                            'name' => 'Certificado SSL (Segurança)',
                            'status' => 1,
                        ],

                        [
                            'name' => '1 Conta de E-mail Profissional',
                            'status' => 1,
                        ],

                        [
                            'name' => 'Subdomínio Sitemas (ex: seusite.sitemas.com.br)',
                            'status' => 1,
                        ],

                        [
                            'name' => 'Inclusas (Ajustes de texto/fotos)',
                            'status' => 1,
                        ],
                    ]
                ),
                'url' => 'https://google.com',
                'status' => 'active',
                'is_recommended' => false,
                'order' => 1,
            ],
            [
                'name' => 'Plano Pro',
                'slug' => 'plano-pro',
                'description' => 'Para empresas que buscam autoridade total.',
                'price' => 149,
                'features' => json_encode(
                    [
                        [
                            'name' => '1 Modelo Premium',
                            'status' => 1,
                        ],

                        [
                            'name' => 'Hospedagem VIP',
                            'status' => 1,
                        ],

                        [
                            'name' => 'Suporte Prioritário via WhatsApp',
                            'status' => 1,
                        ],

                        [
                            'name' => 'Manutenção Técnica & Atualizações',
                            'status' => 1,
                        ],

                        [
                            'name' => 'Certificado SSL (Segurança)',
                            'status' => 1,
                        ],

                        [
                            'name' => 'Até 5 Contas de E-mail Profissionais',
                            'status' => 1,
                        ],

                        [
                            'name' => 'Configuração de Domínio Próprio (.com.br)',
                            'status' => 1,
                        ],

                        [
                            'name' => 'Inclusas (Ajustes de texto/fotos)',
                            'status' => 1,
                        ],
                    ]
                ),
                'url' => 'https://google.com',
                'status' => 'active',
                'is_recommended' => true,
                'order' => 2,
            ],
        ]);
    }
}
