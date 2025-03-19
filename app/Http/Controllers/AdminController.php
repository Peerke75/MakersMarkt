<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Categorie;
use App\Models\Review;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

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
        $badWords = file(storage_path('app/badwords.txt'), FILE_IGNORE_NEW_LINES);
        if (empty($badWords)) {
            return response()->json(['error' => 'Bad words file is empty or not found.']);
        }


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
        $badWords = file(storage_path('app/badwords.txt'), FILE_IGNORE_NEW_LINES);

        if (empty($badWords)) {
            return response()->json(['error' => 'Bad words file is empty or not found.']);
        }

        $products = Product::where(function ($query) use ($badWords) {
            foreach ($badWords as $word) {
                $query->orWhere('description', 'LIKE', "%{$word}%");
            }
        })->get();

        foreach ($products as $product) {
            foreach ($badWords as $word) {
                if (stripos($product->description, $word) !== false) {

                    $product->description = preg_replace('/(' . preg_quote($word, '/') . ')/i', '<span class="text-red-500 font-bold">$1</span>', $product->description);
                }
            }
        }

        $categories = Categorie::all();
        $users = User::all();

        return view('admin.index', compact('products', 'badWords', 'categories', 'users'));
    }

    public function getStatistics()
    {

        $categories = Product::with('categorie')
            ->selectRaw('categorie_id, COUNT(*) as count')
            ->groupBy('categorie_id')
            ->get();


        $ratings = Product::with('reviews', 'categorie')
            ->get()
            ->mapWithKeys(function ($product) {

                $avgRating = $product->reviews->avg('rating');
                return [$product->name => $avgRating ?: 0];
            });


        $popularProducts = Product::withSum('orderLines as total_quantity', 'quantity')
        ->orderByDesc('total_quantity')
        ->limit(5)
        ->get();

        return response()->json([
            'categories' => [
                'labels' => $categories->pluck('categorie.name'),
                'data' => $categories->pluck('count'),
            ],
            'ratings' => [
                'labels' => $ratings->keys(),
                'data' => $ratings->values(),
            ],
            'popular' => [
                'labels' => $popularProducts->pluck('name'),
                'data' => $popularProducts->pluck('total_quantity'),
            ],
        ]);
    }
}
