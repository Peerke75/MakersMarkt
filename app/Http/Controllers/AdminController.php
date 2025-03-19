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

        $products = $query->get();
        $categories = Categorie::all();
        $users = User::all();
        $badWords = ['vloekwoord1', 'vloekwoord2', 'scheldwoord'];

        return view('admin.index', compact('products', 'categories', 'users', 'badWords'));
    }

    public function descriptionEdit($id)
    {
        $product = Product::findOrFail($id);

        return view('admin.description.edit', compact('product'));
    }


    public function descriptionUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
        ]);

        $product = Product::findOrFail($id);

        $product->name = $request->name;
        $product->description = $request->description;

        $product->save();

        return redirect()->route('admin.index')->with('success', 'beschrijving succesvol bijgewerkt!');
    }


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

    public function activate(Product $product)
    {
        $product->update(['status' => 'active']);
        return redirect()->route('admin.index')->with('success', 'Product is geactiveerd!');
    }

    public function deactivate(Product $product)
    {
        $product->update(['status' => 'inactive']);
        return redirect()->route('admin.index')->with('error', 'Product is gedeactiveerd.');
    }

    public function checkForInappropriateLanguage(Request $request)
    {
        $badWords = ['vloekwoord1', 'vloekwoord2', 'scheldwoord'];


        $products = Product::where(function ($query) use ($badWords) {
            foreach ($badWords as $word) {
                $query->orWhere('description', 'LIKE', "%{$word}%");
            }
        })->get();

        $categories = Categorie::all();
        $users = User::all();

        return view('admin.index', compact('products', 'badWords', 'categories', 'users'));
    }
}
