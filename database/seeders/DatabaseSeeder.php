<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CategorieSeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
            OrderLinesSeeder::class,
            UserProductSeeder::class,
            ReviewSeeder::class,
            NotificationSeeder::class,
        ]);
    }
}
