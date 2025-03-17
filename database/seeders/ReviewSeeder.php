<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        // Haal bestaande users en producten op
        $users = DB::table('users')->pluck('id');
        $products = DB::table('products')->pluck('id');

        if ($users->isEmpty() || $products->isEmpty()) {
            $this->command->warn("Geen gebruikers of producten gevonden. Seeder gestopt.");
            return;
        }

        // 20 dummy reviews toevoegen
        for ($i = 0; $i < 10; $i++) {
            DB::table('review')->insert([
                'user_id' => $users->random(),
                'product_id' => $products->random(),
                'description' => Str::random(50),
                'rating' => round(mt_rand(10, 50) / 10, 1), // Random float tussen 1.0 en 5.0
                'review_added' => Carbon::now()->subDays(rand(1, 30)), // Random datum in de laatste 30 dagen
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('20 reviews met decimal ratings succesvol toegevoegd!');
    }
}
