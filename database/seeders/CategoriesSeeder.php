<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            ['category_name' => 'Fiksi', 'created_at' => now(), 'updated_at' => null],
            ['category_name' => 'Non-Fiksi', 'created_at' => now(), 'updated_at' => null],
            ['category_name' => 'Komik', 'created_at' => now(), 'updated_at' => null],
            ['category_name' => 'Biografi', 'created_at' => now(), 'updated_at' => null],
            ['category_name' => 'Teknologi', 'created_at' => now(), 'updated_at' => null],
        ]);
    }
}
