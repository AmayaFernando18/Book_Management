<?php

namespace Database\Seeders;

use App\Models\BookCategory;
use Illuminate\Database\Seeder;

class BookCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Fiction'],
            ['name' => 'Non-Fiction'],
            ['name' => 'Science'],
            ['name' => 'History'],
            ['name' => 'Technology'],
        ];

        foreach ($categories as $category) {
            BookCategory::create($category);
        }
    }
}
