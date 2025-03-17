<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'categorie_id' => \App\Models\Categorie::factory(),
            'maker_id' => \App\Models\User::factory(),
            'name' => $this->faker->word(),
            'status' => 'active',
            'status_change' => null,
            'description' => $this->faker->sentence(),
            'production_time' => $this->faker->randomElement(['1-3 maanden', '4-6 maanden', '7-9 maanden', '10-12 maanden']),
            'material' => $this->faker->randomElement(['hout', 'metaal', 'kunststof', 'glas']),
            'price' => $this->faker->randomFloat(2, 5, 500),
            'quantity' => $this->faker->numberBetween(1, 50),
            'image' => null,
            'link' => null,
        ];
    }
}
