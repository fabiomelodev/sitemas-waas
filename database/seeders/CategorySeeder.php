<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            ['name' => 'Business', 'slug' => 'business', 'status' => 'active'],
            ['name' => 'Technology', 'slug' => 'technology', 'status' => 'active'],
            ['name' => 'Health', 'slug' => 'health', 'status' => 'active'],
            ['name' => 'Education', 'slug' => 'education', 'status' => 'active'],
        ]);
    }
}
