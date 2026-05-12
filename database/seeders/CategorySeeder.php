<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Business',
                'slug' => 'business',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Technology',
                'slug' => 'technology',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Health',
                'slug' => 'health',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Education',
                'slug' => 'education',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
