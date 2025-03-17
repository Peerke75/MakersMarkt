<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Categorie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioTest extends TestCase
{
    use RefreshDatabase; // Database wordt geleegd na elke test

    /** @test */
    public function it_validates_required_fields()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('portfolio.store'), []);

        $response->assertSessionHasErrors([
            'name',
            'description',
            'categorie_id',
            'production_time',
            'material',
            'price',
            'quantity',
        ]);
    }

    /** @test */
    public function it_creates_a_product_successfully()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $category = Categorie::factory()->create();

        $data = [
            'name' => 'Test Product',
            'description' => 'Dit is een testproduct',
            'categorie_id' => $category->id,
            'production_time' => '1-3 maanden',
            'material' => 'hout',
            'price' => 29.99,
            'quantity' => 5,
        ];

        $response = $this->post(route('portfolio.store'), $data);

        $response->assertRedirect(); // Moet naar portfolio pagina sturen
        $this->assertDatabaseHas('products', $data);
    }

    /** @test */
    public function it_displays_products_in_portfolio()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create(['maker_id' => $user->id]);

        $response = $this->get(route('portfolio.index'));

        $response->assertStatus(200);
        $response->assertSee($product->name);
    }

    /** @test */
    public function it_updates_a_product()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create(['maker_id' => $user->id]);

        $updatedData = [
            'name' => 'Updated Product',
            'description' => 'Nieuwe beschrijving',
            'categorie_id' => $product->categorie_id,
            'production_time' => '4-6 maanden',
            'material' => 'metaal',
            'price' => 49.99,
            'quantity' => 10,
        ];

        $response = $this->put(route('portfolio.update', $product->id), $updatedData);

        $response->assertRedirect();
        $this->assertDatabaseHas('products', $updatedData);
    }

    /** @test */
    public function it_deletes_a_product()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $product = Product::factory()->create(['maker_id' => $user->id]);

        $response = $this->delete(route('portfolio.destroy', $product->id));

        $response->assertRedirect();
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
