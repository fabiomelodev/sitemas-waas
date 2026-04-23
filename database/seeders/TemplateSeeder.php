<?php

namespace Database\Seeders;

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
                'excerpt' => 'This is a short description of Template 1.',
                'url' => 'https://example.com/template1',
                'subscription_link' => 'https://example.com/subscribe/template1',
                'thumbnail' => null,
                'category_id' => 1,
                'status' => 'active',
            ],
            [
                'name' => 'Template 2',
                'excerpt' => 'This is a short description of Template 2.',
                'url' => 'https://example.com/template2',
                'subscription_link' => 'https://example.com/subscribe/template2',
                'thumbnail' => null,
                'category_id' => 2,
                'status' => 'active',
            ],
        ]);
    }
}
