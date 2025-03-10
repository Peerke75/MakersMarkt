<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserProductSeeder extends Seeder
{
    public function run()
    {
        DB::table('user_product')->insert([
            ['user_id' => 2, 'product_id' => 1],
            ['user_id' => 2, 'product_id' => 2]
        ]);
    }
}
