<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    // Indexpagina voor admin: productenbeheer
    public function index(Request $request)
    {
        $query = Product::query();

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

        // Producten ophalen
        $products = $query->get();
        $categories = Categorie::all();
        $users = User::all();

        return view('admin.index', compact('products', 'categories','users'));
    }

    // Verwijderen van een product
    public function destroyProduct(Product $product)
    {

        $product->orderLines()->delete();

        $product->reviews()->delete();

        $product->users()->detach();

        $product->delete();

        return redirect()->route('admin.index')->with('success', 'Product succesvol verwijderd');
    }
    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.index')->with('success', 'Gebruiker succesvol verwijderd');
    }
}
