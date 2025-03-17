<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index($id)
    {
        $product = Product::findOrFail($id);
        $reviews = Review::all();
        return view('reviews.index',compact ('reviews', 'product'));
    }

    public function show($id)
    {
        $review = Review::findOrFail($id);
        return view('reviews.show', compact('review'));
    }

    public function create($id)
    {
        $product = Product::findOrFail($id);
        return view('reviews.create', compact('product'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'description' => 'required|string|max:255',
            'rating' => 'required|numeric|min:1|max:5', // ✅ Nu ook decimalen toegestaan
        ]);

        // ✅ Review opslaan zonder 'user_id' en 'review_added' in de request te zetten
        $review = Review::create([
            'user_id' => auth()->id(), // ✅ Pak direct de ingelogde gebruiker
            'product_id' => $request->product_id,
            'description' => $request->description,
            'rating' => $request->rating,
            'review_added' => now(), // ✅ Automatisch huidige tijd invullen
        ]);

        // ✅ Check of de review correct is aangemaakt
        if (!$review) {
            return redirect()->back()->with('error', 'Er ging iets mis met het opslaan van je review.');
        }

        return redirect()->route('reviews', $id)->with('success', 'Review succesvol aangemaakt!');
    }

    public function search(Request $request)
    {
        $query = $request->get('query');

        $reviews = \App\Models\Review::whereHas('user', function($query) use ($request) {
            $query->where('name', 'LIKE', "%{$request->query}%");
        })
            ->limit(5)
            ->get();

        return response()->json($reviews);
    }


}
