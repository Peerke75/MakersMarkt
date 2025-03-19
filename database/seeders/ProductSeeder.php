<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            [
                'categorie_id' => 1,
                'maker_id' => 3,
                'name' => 'Laptop',
                'status' => 'active',
                'status_change' => null,
                'description' => 'Powerful gaming laptop',
                'production_time' => '4-6 maanden',
                'material' => 'metaal',
                'price' => 1299.99,
                'quantity' => 10,
                'image' => 'laptop.jpg',
                'link' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categorie_id' => 2,
                'maker_id' => 3,
                'name' => 'Book - Laravel Guide',
                'status' => 'active',
                'status_change' => null,
                'description' => 'Comprehensive Laravel tutorial',
                'production_time' => '1-3 maanden',
                'material' => 'papier',
                'price' => 39.99,
                'quantity' => 50,
                'image' => 'laravel_guide.jpg',
                'link' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}