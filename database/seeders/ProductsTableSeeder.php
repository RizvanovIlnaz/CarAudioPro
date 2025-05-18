<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'Акустическая система Pioneer TS-1339',
                'price' => 8990,
                'is_recommended' => true,
            ],
            [
                'name' => 'Сабвуфер Alpine SWE-815',
                'price' => 14990,
                'is_recommended' => true,
            ],
            // Добавьте другие товары
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
