<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run()
    {
        DB::table('orders')->insert([
            [
                'maker_id' => 1,
                'koper_id' => 2,
                'completed_at' => Carbon::now(),
                'status' => 'verzonden',
                'status_message' => 'Order has been shipped',
                'total_price' => 99.99,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'maker_id' => 2,
                'koper_id' => 1,
                'completed_at' => Carbon::now(),
                'status' => 'geweigerd, terugbetaling verzonden',
                'status_message' => 'Order has been refunded',
                'total_price' => 49.99,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'maker_id' => 3,
                'koper_id' => 4,
                'completed_at' => Carbon::now(),
                'status' => 'verzonden',
                'status_message' => 'Order has been shipped',
                'total_price' => 199.99,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'maker_id' => 4,
                'koper_id' => 3,
                'completed_at' => Carbon::now(),
                'status' => 'geweigerd, terugbetaling verzonden',
                'status_message' => 'Order has been refunded',
                'total_price' => 149.99,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
