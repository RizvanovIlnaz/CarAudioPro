<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Динамики', 'slug' => 'dynamics'],
            ['name' => 'Усилители', 'slug' => 'amplifiers'],
            ['name' => 'Сабвуферы', 'slug' => 'subwoofers'],
            ['name' => 'Акустические провода', 'slug' => 'cables'],
            ['name' => 'Шумоизоляция', 'slug' => 'soundproofing'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}