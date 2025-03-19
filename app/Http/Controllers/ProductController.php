<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Order;
use App\Models\Product;
use App\Models\UserProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('status','active');

        // Filters toepassen
        if ($request->has('categorie_id') && $request->categorie_id != '') {
            $query->where('categorie_id', $request->categorie_id);
        }
        if ($request->has('production_time') && $request->production_time != '') {
            $query->where('production_time', $request->production_time);
        }
        if ($request->has('material') && $request->material != '') {
            $query->where('material', $request->material);
        }

        $products = $query->get();
        $categories = Categorie::all();

        return view('products.index', compact('products', 'categories'));
    }


    public function show($id)
    {
        $categories = Categorie::all();
        $product = Product::findOrFail($id);
        return view('products.show', compact('product', 'categories'));
    }
    public function buy(Product $product)
    {
        $cart = session()->get('cart', []);

        return view('products.buy-in', compact('product', 'cart'));
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
        $query = $request->query('query');

        $products = Product::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->get();

        return response()->json($products);
    }

    public function addCategories(Request $request, Product $product)
    {
        // Valideer invoer
        $request->validate([
            'categorie_id' => 'required|exists:categories,id',
            'material' => 'nullable|string|max:255',
            'production_time' => 'nullable|string|max:255',
        ]);

        // Werk het product bij
        $product->update([
            'categorie_id' => $request->categorie_id, // Enkele categorie
            'material' => $request->material,
            'production_time' => $request->production_time,
        ]);

        return redirect()->back()->with('success', 'Categorie en filters bijgewerkt!');
    }

}
