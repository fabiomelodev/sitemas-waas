<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('templates')->insert([
            [
                'name' => 'Template 1',
                'slug' => 'template-1',
                'excerpt' => 'This is a short description of Template 3.',
                'url' => 'https://example.com/template3',
                'subscription_link' => 'https://example.com/subscribe/template3',
                'thumbnail' => null,
                'features' => json_encode(
                    [
                        [
                            'name' => 'Estrutura de até 6 páginas'
                        ],

                        [
                            'name' => 'Otimizado para Mobile'
                        ],

                        [
                            'name' => 'Blog integrado'
                        ],

                        [
                            'name' => 'Formulários de Contato'
                        ],
                    ]
                ),
                'category_id' => 1,
                'plan_id' => 1,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Template 2',
                'slug' => 'template-2',
                'excerpt' => 'This is a short description of Template 4.',
                'url' => 'https://example.com/template4',
                'subscription_link' => 'https://example.com/subscribe/template4',
                'thumbnail' => null,
                'features' => json_encode(
                    [
                        [
                            'name' => 'Estrutura de até 6 páginas'
                        ],

                        [
                            'name' => 'Otimizado para Mobile'
                        ],

                        [
                            'name' => 'Blog integrado'
                        ],

                        [
                            'name' => 'Formulários de Contato'
                        ],
                    ]
                ),
                'category_id' => 2,
                'plan_id' => 1,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Template 3',
                'slug' => 'template-3',
                'excerpt' => 'This is a short description of Template 4.',
                'url' => 'https://example.com/template4',
                'subscription_link' => 'https://example.com/subscribe/template4',
                'thumbnail' => null,
                'features' => json_encode(
                    [
                        [
                            'name' => 'Estrutura de até 6 páginas'
                        ],

                        [
                            'name' => 'Otimizado para Mobile'
                        ],

                        [
                            'name' => 'Blog integrado'
                        ],

                        [
                            'name' => 'Formulários de Contato'
                        ],
                    ]
                ),
                'category_id' => 3,
                'plan_id' => 2,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
