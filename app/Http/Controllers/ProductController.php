<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.products-show', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.products-info', compact('product'));
    }
    public function buy(Product $product)
    {
        return view('products.products-buy-in', compact('product'));
    }

    public function create()
    {
        return view('products.products-create');
    }

    public function store(Request $request)
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

        // Nieuw product aanmaken
        $product = Product::create([

            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'material' => $request->material,
            'description' => $request->description,
            'production_time' => $request->production_time,
            'categorie_id' => $request->categorie_id,
            'image' => $request->image,
        ]);

        session()->flash('success', 'Product succesvol aangemaakt!');

        return redirect()->route('products');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.products-edit', compact('product'));
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
