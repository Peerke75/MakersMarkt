<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
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

    public function create()
    {
        $categories = Categorie::all();

        return view('portfolio.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'categorie_id' => 'required|exists:categories,id',
            'production_time' => 'required|in:1-3 maanden,4-6 maanden,7-9 maanden,10-12 maanden',
            'material' => 'required|in:hout,metaal,kunststof,glas,steen,textiel,leer,papier,keramiek,overig',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->categorie_id = $request->categorie_id;
        $product->production_time = $request->production_time;
        $product->material = $request->material;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->maker_id = Auth::id();

        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->save();

        return redirect()->route('portfolio.index')->with('success', 'Product succesvol toegevoegd!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Categorie::all();

        return view('portfolio.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'categorie_id' => 'required|exists:categories,id',
            'production_time' => 'required|in:1-3 maanden,4-6 maanden,7-9 maanden,10-12 maanden',
            'material' => 'required|in:hout,metaal,kunststof,glas,steen,textiel,leer,papier,keramiek,overig',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $product = Product::findOrFail($id);

        if ($product->maker_id !== Auth::id()) {
            return redirect()->route('portfolio.index')->with('error', 'Je hebt geen rechten om dit product te bewerken.');
        }

        $product->name = $request->name;
        $product->description = $request->description;
        $product->categorie_id = $request->categorie_id;
        $product->production_time = $request->production_time;
        $product->material = $request->material;
        $product->price = $request->price;
        $product->quantity = $request->quantity;

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->save();

        return redirect()->route('portfolio.index')->with('success', 'Product succesvol bijgewerkt!');
    }

    public function destroy(Product $product)
    {
        // Verwijder de afbeelding uit de storage als die bestaat
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Verwijder het product
        $product->delete();

        // Redirect met een succesmelding
        return redirect()->route('portfolio.index')->with('success', 'Product succesvol verwijderd!');
    }

}
