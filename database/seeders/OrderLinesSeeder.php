<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderLinesSeeder extends Seeder
{
    public function run()
    {
        DB::table('order_lines')->insert([
            [
                'order_id' => 1,
                'product_id' => 1,
                'amount' => 1
            ],
            [
                'order_id' => 1,
                'product_id' => 2,
                'amount' => 2
            ]
        ]);
    }
}
