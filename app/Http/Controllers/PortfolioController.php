<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class PortfolioController extends Controller
{
    /**
     * Toon het portfolio van de ingelogde maker.
     */
    public function index()
    {
        $products = Product::where('maker_id', Auth::id())->get();
        return view('portfolio.index', compact('products'));
    }

    /**
     * Toon de pagina om een nieuw product toe te voegen.
     */
    public function create()
    {
        return view('portfolio.create');
    }

    /**
     * Sla een nieuw product op in de database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'production_time' => 'required|in:1-3 maanden,4-6 maanden,7-9 maanden,10-12 maanden',
            'material' => 'required|in:hout,metaal,kunststof,glas,steen,textiel,leer,papier,keramiek,overig',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $product = new Product();
        $product->maker_id = Auth::id();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->categorie_id = $request->category_id;
        $product->production_time = $request->production_time;
        $product->material = $request->material;
        $product->price = $request->price;
        $product->quantity = $request->quantity;

        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->save();

        return redirect()->route('portfolio.index')->with('success', 'Product toegevoegd aan je portfolio!');
    }

    /**
     * Toon het bewerkformulier voor een product.
     */
    public function edit(Product $product)
    {
        $this->authorize('update', $product);
        return view('portfolio.edit', compact('product'));
    }

    /**
     * Werk een product bij in de database.
     */
    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'production_time' => 'required|in:1-3 maanden,4-6 maanden,7-9 maanden,10-12 maanden',
            'material' => 'required|in:hout,metaal,kunststof,glas,steen,textiel,leer,papier,keramiek,overig',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $product->name = $request->name;
        $product->description = $request->description;
        $product->categorie_id = $request->category_id;
        $product->production_time = $request->production_time;
        $product->material = $request->material;
        $product->price = $request->price;
        $product->quantity = $request->quantity;

        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->save();

        return redirect()->route('portfolio.index')->with('success', 'Product succesvol bijgewerkt!');
    }

    /**
     * Verwijder een product.
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        $product->delete();
        return redirect()->route('portfolio.index')->with('success', 'Product verwijderd uit je portfolio.');
    }
}
