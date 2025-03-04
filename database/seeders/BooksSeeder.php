<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BooksSeeder extends Seeder
{
    public function run()
    {
        DB::table('books')->insert([
            [
                'title' => 'Buku Laravel',
                'author' => 'John Doe',
                'publisher' => 'Tech Press',
                'year' => '2023',
                'isbn' => '1234567890',
                'category_id' => 1,
                'stock' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Belajar PHP',
                'author' => 'Jane Doe',
                'publisher' => 'Dev Books',
                'year' => '2022',
                'isbn' => '0987654321',
                'category_id' => 5,
                'stock' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
