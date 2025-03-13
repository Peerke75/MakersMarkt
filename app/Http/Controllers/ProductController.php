<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\UserProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }
    public function buy(Product $product)
    {
        return view('products.buy-in', compact('product'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'material' => 'required|string',
            'description' => 'required|string',
            'production_time' => 'required|string',
            'categorie_id' => 'required|exists:categories,id',
            'image' => 'nullable|string',
        ]);

        // Nieuw product aanmaken
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'material' => $request->material,
            'description' => $request->description,
            'production_time' => $request->production_time,
            'categorie_id' => $request->categorie_id,
            'image' => $request->image,
        ]);

        // Product koppelen aan de ingelogde gebruiker
        UserProduct::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
        ]);

        return redirect()->route('products.index')->with('success', 'Product toegevoegd!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'material' => 'required|string',
            'description' => 'required|string',
            'production_time' => 'required|string',
            'categorie_id' => 'required|exists:categories,id',
            'image' => 'nullable|string',
        ]);

        $product = Product::findOrFail($id);
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'material' => $request->material,
            'description' => $request->description,
            'production_time' => $request->production_time,
            'categorie_id' => $request->categorie_id,
            'image' => $request->image,
        ]);

        session()->flash('success', 'Product succesvol bijgewerkt!');

        return redirect()->route('products');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        session()->flash('success', 'Product succesvol verwijderd!');

        return redirect()->route('products');
    }

    public function search(Request $request)
    {
        $query = $request->get('query');

        $products = \App\Models\Product::where('name', 'LIKE', "%{$query}%")
            ->limit(5)
            ->get();

        return response()->json($products);
    }
}
