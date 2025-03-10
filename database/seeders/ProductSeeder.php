<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            [
                'categorie_id' => 1,
                'name' => 'Laptop',
                'description' => 'Powerful gaming laptop',
                'price' => 1299.99,
                'image' => 'laptop.jpg'
            ],
            [
                'categorie_id' => 2,
                'name' => 'Book - Laravel Guide',
                'description' => 'Comprehensive Laravel tutorial',
                'price' => 39.99,
                'image' => 'laravel_guide.jpg'
            ]
        ]);
    }
}
